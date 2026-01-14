<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Project;
use App\Models\User;

class projectSnap extends Component
{
    public Project $project;
    public $available_users;
    /**
     * Create a new component instance.
     */
    public function __construct(Project  $project)
    {
        $this->available_users = User::whereHas('role', function ($query) {
            $query->where('name', 'user')->orWhere('name', 'admin');
        })->get();
        $this->project = $project;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.project-snap', ['project', $this->project]);
    }
}
