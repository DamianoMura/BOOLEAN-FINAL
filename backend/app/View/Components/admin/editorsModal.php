<?php

namespace App\View\Components\admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\User;

class editorsModal extends Component
{
    public $project;
    public $availableEditors = [];
    /**
     * Create a new component instance.
     */
    public function __construct($project)
    {
        $this->project = $project;
        $this->availableEditors = User::whereHas('role', function ($query) {
            $query->where('name', 'user')->orWhere('name', 'admin');
        })->where('id', '!=', auth()->id())->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.editors-modal');
    }
}
