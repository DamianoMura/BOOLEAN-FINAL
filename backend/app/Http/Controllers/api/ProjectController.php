<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search') && strlen($request->search) > 25) {
            return response()->json([
                'success' => false,
                'message' => 'the field is too long',
                'error_code' => 'SEARCH_TOO_LONG'
            ], 400);
        }
        // Costruisci e esegui la query con paginazione
        $query = Project::with([
            'category',
            'technology',
            'sections' => function ($query) {
                $query->where('published', true)
                    ->orderBy('order')
                    ->select('id', 'project_id', 'title', 'content', 'order');
            },
            'user' => function ($query) {
                $query->select('id', 'name');
            }
        ])
            ->where('published', true)
            ->select('id', 'slug', 'title', 'description', 'github_url', 'category_id', 'author_id', 'created_at', 'updated_at');

        // Applica filtri
        $this->applyFilters($query, $request);

        // Paginazione
        $perPage = $request->get('per_page', 5);
        $maxPerPage = 5;
        $perPage = min($perPage, $maxPerPage);

        $projects = $query->paginate($perPage);
        // dd($projects);

        // Trasforma i risultati per l'API
        $transformedProjects = $projects->getCollection()->map(function ($project) {
            return [
                'id' => $project->id,
                'slug' => $project->slug,
                'title' => $project->title,
                'github_url' => $project->github_url,
                'description' => $project->description,
                'created_at' => $project->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $project->updated_at->format('Y-m-d H:i:s'),
                'category' => $project->category->label,

                'author' => $project->user->name,

                'technologies' => $project->technology->map(function ($tech) {
                    return [
                        'id' => $tech->id,
                        'name' => $tech->name,
                        'label' => $tech->label,
                        'fontawesome_class' => $tech->fontawesome_class ?? null,
                    ];
                }),

                'stats' => [
                    'sections_count' => $project->sections->count(),
                    'technologies_count' => $project->technology->count(),
                ]
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $transformedProjects,
            'meta' => [
                'total' => $projects->total(),
                'per_page' => $projects->perPage(),
                'current_page' => $projects->currentPage(),
                'last_page' => $projects->lastPage(),
                'from' => $projects->firstItem(),
                'to' => $projects->lastItem(),
            ],
            'links' => [
                'first' => $projects->url(1),
                'last' => $projects->url($projects->lastPage()),
                'prev' => $projects->previousPageUrl(),
                'next' => $projects->nextPageUrl(),
            ]
        ]);
    }

    protected function applyFilters($query, $request)
    {
        // Filtro per categoria (per ID o nome)
        if ($request->filled('category')) {
            if ($request->category != 'all') {
                if (is_numeric($request->category)) {
                    $query->where('category_id', $request->category);
                } else {
                    $query->whereHas('category', function ($q) use ($request) {
                        $q->where('name', $request->category);
                    });
                }
            }
        }

        // Filtro per tecnologia (ID )
        if ($request->filled('technology')) {
            $query->whereHas('technology', function ($q) use ($request) {
                $q->where('technology_id', $request->technology);
            });
        }

        // Filtro per autore
        if ($request->filled('author')) {
            if (is_numeric($request->author)) {
                $query->where('author_id', $request->author);
            } else {
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->author . '%');
                });
            }
        }

        // Filtro per ricerca
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                    ->orWhere('description', 'like', $searchTerm)
                    ->orWhereHas('technology', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', $searchTerm);
                    })
                    ->orWhereHas('category', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', $searchTerm);
                    })
                    ->orWhereHas('user', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', $searchTerm);
                    });
            });
        }

        // Ordinamento
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $validSortColumns = ['created_at', 'title', 'updated_at', 'id'];
        if (!in_array($sortBy, $validSortColumns)) {
            $sortBy = 'created_at';
        }

        $query->orderBy($sortBy, $sortOrder);

        return $query;
    }

    public function show($slug)
    {

        $project = Project::with([
            'category',
            'technology',
            'sections' => function ($query) {
                $query->where('published', true)
                    ->orderBy('order');
            },
            'user',
            'editor' => function ($query) {
                $query->select('user_id', 'name', 'email');
            }
        ])
            ->where('published', true)
            ->where('slug', $slug)
            ->first();

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $project->id,
                'slug' => $project->slug,
                'title' => $project->title,
                'github_url' => $project->github_url,
                'description' => $project->description,
                'created_at' => $project->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $project->updated_at->format('Y-m-d H:i:s'),
                'category' => $project->category->label,
                'author' => $project->user->name,

                'technologies' => $project->technology->map(function ($tech) {
                    return [
                        'id' => $tech->id,
                        'name' => $tech->name,
                        'label' => $tech->label,
                        'fontawesome_class' => $tech->fontawesome_class ?? null,
                    ];
                }),
                'sections' => $project->sections->map(function ($section) {
                    return [
                        'id' => $section->id,
                        'title' => $section->title,
                        'content' => $section->content,
                        'order' => $section->order,
                        'author' => $section->author->name,
                        'created_at' => $section->created_at->format('Y-m-d H:i:s'),

                    ];
                }),
                'editors' => $project->editor->map(function ($editor) use ($project) {
                    return $editor->name != $project->user->name ? $editor->name : null;
                })->filter()->values(),

            ]
        ]);
    }
}
