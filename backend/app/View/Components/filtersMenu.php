<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;

class filtersMenu extends Component
{
    public $categories;
    public $technologies;
    public $stats;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->categories = Category::orderBy('name')->get();
        $this->technologies = Technology::orderBy('name')->get();
        $this->stats['total'] = Project::all()->count();
        $this->stats['published'] = Project::where('published', true)->count();
        $this->stats['drafts'] = Project::where('published', false)->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.filters-menu');
    }
}
