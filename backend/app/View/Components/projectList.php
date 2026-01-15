<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ProjectController;

class projectList extends Component
{
    public $available_users;
    public $projects;
    public $stats;

    /**
     * Create a new component instance.
     */
    public function __construct(Request $request)
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
        $results = ProjectController::applyQueries($request, $query);
        // $dd($results);
        $this->projects = $results['projects'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.project-list');
    }
}
