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
    public $totalSections; // Aggiungi questa proprietà

    /**
     * Create a new component instance.
     */
    public function __construct($section)
    {
        $this->section = $section;

        // Carica il progetto con le relazioni necessarie
        $this->project = Project::with(['sections', 'editor'])->find($section->project_id);

        // Calcola il totale delle sezioni una volta sola
        $this->totalSections = $this->project->sections->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.editors.project-section-component');
    }
}
