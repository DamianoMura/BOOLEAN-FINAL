<?php

namespace App\View\Components\admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class editorSection extends Component
{
    public $current_project;
    /**
     * Create a new component instance.
     */
    public function __construct($project)
    {
        $this->current_project = $project;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.editor-section');
    }
}
