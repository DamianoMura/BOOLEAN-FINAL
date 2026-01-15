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


    /**
     * Create a new component instance.
     */
    public function __construct()
    {

        $this->categories = Category::orderBy('name')->get();
        $this->technologies = Technology::orderBy('name')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.filters-menu');
    }
}
