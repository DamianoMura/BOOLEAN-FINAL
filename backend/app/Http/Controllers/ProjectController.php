<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
        return view('auth.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Project $project) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {

        return route('auth.projects.index', ['status', 'project have been deleted']);
    }
    public function assignEditor(Request $request)
    {

        // Validation
        $project = Project::find($request->project_id);
        $project->editor()->attach($request->user_id);


        $project->save();

        return back()->with('status', 'Added New Editor');
    }
    public function removeEditor(Request $request)
    {
        // Validazione
        $project = Project::find($request->project_id);
        $project->editor()->detach($request->user_id);


        $project->save();

        return back()->with('status', 'Editor Removed');
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
