<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class availableUsers extends Component
{

    /* this components is just a list of available users that can be added to work on projects
    */
    public $user_names = [];
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'user')->orWhere('name', 'admin');
        })->where('id', '!=', Auth::id())->get();


        foreach ($users as $user)
            $this->user_names[] = $user->name;

        // dd($user_names);

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.available-users', ['user_names' => $this->user_names]);
    }
}
