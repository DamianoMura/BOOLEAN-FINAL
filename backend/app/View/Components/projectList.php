<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\User;
use App\Models\Role;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class projectList extends Component
{
    public $available_users;
    public $projects;
    public $categories;
    public $technologies;
    public $stats;
    /**
     * Create a new component instance.
     */
    public function __construct($search = null, $category = null, $technology = null, $published = null, $perPage = 12)
    {
        //lista dei propri progetti e degli utenti selezionabili come editor
        $this->available_users = User::whereHas('role', function ($query) {
            $query->where('name', 'user')->orWhere('name', 'admin');
        })->get();
        $query = Project::query()
            ->with(['category', 'user', 'technology', 'editor'])
            ->where(function ($q) {
                $q->where('author_id', Auth::id())
                    ->orWhereHas('editor', function ($subQuery) {
                        $subQuery->where('user_id', Auth::id());
                    });
            });

        // Applica filtri
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }



        if (!is_null($published)) {
            $query->where('published', $published === 'true');
        }

        $this->projects = $query->latest()->paginate($perPage);


        // Statistiche
        $this->stats = [
            'total' => Project::where(function ($q) {
                $q->where('author_id', Auth::id())
                    ->orWhereHas('editor', function ($subQuery) {
                        $subQuery->where('user_id', Auth::id());
                    });
            })->count(),
            'published' => Project::where(function ($q) {
                $q->where('author_id', Auth::id())
                    ->orWhereHas('editor', function ($subQuery) {
                        $subQuery->where('user_id', Auth::id());
                    });
            })->where('published', true)->count(),
            'drafts' => Project::where(function ($q) {
                $q->where('author_id', Auth::id())
                    ->orWhereHas('editor', function ($subQuery) {
                        $subQuery->where('user_id', Auth::id());
                    });
            })->where('published', false)->count(),
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.project-list');
    }
}
