<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Technology;

class ProjectController extends Controller
{

    public function index(Request $request)
    {




        $results = $this->applyQueries($request);

        $projects = $results['projects'];

        return view('auth.projects.index', compact('projects'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $technologies = Technology::all();
        $categories = Category::all()->where('name', '!=', 'NDC');
        return view('auth.projects.create', compact('technologies', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $project = new Project();


        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'technologies' => 'nullable|array',
            'published'   =>  'nullable|boolean',
            'technologies.*' => 'exists:technologies,id',

        ]);
        $project = Project::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'category_id' => $validated['category_id'] ?? 1,
            'published' => $request->boolean('published') ?? 0,
            'author_id' => Auth::id(),
        ]);


        if (isset($validated['technologies']) && !empty($validated['technologies'])) {
            $project->technologies()->attach($validated['technologies']);
        }
        $project->editor()->attach(Auth::user());
        return redirect()->route('projects.show', $project)->with('status', 'Project ' . $project->title . ' created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('auth.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $technologies = Technology::all();
        $categories = Category::all();
        return view('auth.projects.edit', compact('project', 'categories', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'technologies' => 'nullable|array',
            'technologies.*' => 'exists:technologies,id',
        ]);

        $project->title = $validated['title'];

        // Usa l'operatore null coalescent per le chiavi nullable
        $project->description = $validated['description'] ?? $project->description;
        $project->category_id = $validated['category_id'] ?? $project->category_id;

        // Usa boolean() con valore di default
        $project->published = $request->boolean('published', false);

        // Gestione delle tecnologie con sync() invece di attach/detach
        if (isset($validated['technologies'])) {
            $project->technology()->sync($validated['technologies']);
        } else {
            $project->technology()->detach();
        }

        $project->save();

        return redirect()->route('projects.show', $project)->with('status', 'Project ' . $project->title . ' edited successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {

        $title = $project->title;
        $project->delete();

        return redirect()->route('projects.index')->with('status', 'Project ' . $title . ' deleted successfully.');
    }


    public function manageEditor(Request $request)
    {

        // Validation

        $project = Project::find($request->project_id);
        if ($request->user_ids) {
            // dd($request->user_ids);
            $project->editor()->detach();

            foreach ($request->user_ids as $editor) {
                $project->editor()->attach($editor);
            }
        } else  $project->editor()->detach();
        $project->editor()->attach(Auth::user());

        $project->save();

        return back()->with('status', 'Added New Editor');
    }


    public static function applyQueries($request)
    {
        if ($request->Uri()->path() == 'projects') {
            $query = Project::query()
                ->with(['category', 'user', 'technology', 'editor'])
                ->withCount(['editor as editors_count']);

            // only admins can see unpublished projects
            if (!Auth::user()->isAdmin()) {
                $query = $query->where('published', true);
            }
        }
        if ($request->Uri()->path() == 'dashboard') {
            $query = Project::query()
                ->with(['category', 'user', 'technology', 'editor'])
                ->where(function ($q) {
                    $q->where('author_id', Auth::id())
                        ->orWhereHas('editor', function ($subQuery) {
                            $subQuery->where('user_id', Auth::id());
                        });
                });
        }
        // Filtro per categoria anti sql injection
        if ($request->filled('category') && $request->category != 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Filtro per tecnologia
        if ($request->filled('technology')) {
            $query->whereHas('technology', function ($q) use ($request) {
                $q->where('technology_id', $request->technology);
            });
        }

        // Filtro per stato pubblicazione
        if ($request->filled('published')) {
            $isPublished = $request->published === 'true';
            $query->where('published', $isPublished);
        }

        // Filtro per ricerca titolo
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('projects.title', 'like', $searchTerm)
                    ->orWhere('projects.description', 'like', $searchTerm);
            });
        }

        // Ordinamento
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        // Assicurati che il campo di ordinamento sia valido
        $validSortColumns = ['created_at', 'title', 'updated_at'];
        if (!in_array($sortBy, $validSortColumns)) {
            $sortBy = 'created_at';
        }

        $query->orderBy('projects.' . $sortBy, $sortOrder);

        // Paginazione
        $projects = $query->paginate(12)->withQueryString();


        // Statistiche


        return [
            'projects' => $projects
        ];
    }
}
