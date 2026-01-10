<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\User;
use App\Models\Role;

class userList extends Component
{
    public $data = [
        'users',
        'roles',
        'devs',
        'admins'
    ];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->data['users'] = User::all();
        $this->data['roles'] = Role::all();
        $this->data['devs'] = Role::where('name', 'dev')->first()->user()->count();
        $this->data['admins'] = Role::where('name', 'admin')->first()->user()->count();;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        return view('components.dev.user-list', ['data' => $this->data]);
    }
}
