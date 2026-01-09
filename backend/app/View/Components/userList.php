<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class userList extends Component
{
    public $users;
    public $devs;
    public $admins;
    public $roles;
    /**
     * Create a new component instance.
     */
    public function __construct($users = [], $roles = [], $devs, $admins)
    {
        $this->users = $users;
        $this->roles = $roles;
        $this->devs = $devs;
        $this->admins = $admins;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user-list');
    }
}
