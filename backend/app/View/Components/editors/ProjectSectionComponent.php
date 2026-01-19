<?php

namespace App\View\Components\editors;


use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectSection;

class ProjectSectionComponent extends Component
{
    public $section;
    public $project;
    public $lastEditor;
    /**
     * Create a new component instance.
     */
    public function __construct($section)
    {
        $this->section = $section;
        $project = Project::where('id', $section->project_id)->first();
        // dd($project->author_id);
        $this->project = $project;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.editors.project-section-component');
    }
}
