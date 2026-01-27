<?php

namespace App\View\Components\editors;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\ProjectSection;

class DeleteProjectSection extends Component
{
    public $project_id;
    public $section;
    /**
     * Create a new component instance.
     */
    public function __construct($projectid, ProjectSection $section)
    {
        $this->project_id = $projectid;
        $this->section = $section;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.editors.delete-project-section');
    }
}
