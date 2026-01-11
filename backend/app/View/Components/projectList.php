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
    public $elements = [
        'projects',
        'available_users'
    ];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //lista dei propri progetti e degli utenti selezionabili come editor



        $this->elements['projects'] = Project::with('editor')->where('author_id', Auth::user()->id)->get();;
        $this->elements['available_users'] = User::whereHas('role', function ($query) {
            $query->where('name', 'user')->orWhere('name', 'admin');
        })->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.project-list', ['elements', $this->elements]);
    }
}
