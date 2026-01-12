<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = [];
        $allProjects = Project::all();
        if (Auth::user()->getRoleName() == 'user') {
            foreach ($allProjects as $project)
                if ($project->hasUserAssigned(Auth::id()) || $project->published == true) {
                    $projects[] = $project;
                }
        } else $projects = $allProjects;



        return view('auth.projects.index', ['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('auth.projects.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
    public function assignEditor(Request $request)
    {
        // Validazione
        $project = Project::find($request->project_id);
        $project->editor()->attach($request->user_id);


        $project->save();

        return back()->with('status', 'Added New Editor');
    }
    public function removeEditor(Request $request)
    {
        // Validazione
        $project = Project::find($request->project_id);
        $project->editor()->detach($request->user_id);


        $project->save();

        return back()->with('status', 'Editor Removed');
    }
}
