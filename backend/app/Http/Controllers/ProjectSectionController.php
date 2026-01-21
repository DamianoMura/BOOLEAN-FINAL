<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectSectionController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',

            'project_id' => 'integer',

        ]);
        $project = Project::findOrFail($validated['project_id']);


        $order = $project->sections()->max('order') + 1;

        $section = ProjectSection::create([
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'position' => $validated['position'] ?? 1,
            'user_id'  => Auth::id(),
            'project_id' => $project->id,
            'last_edited_by' => Auth::id(),
            'order' => $order,
            'last_edited_by' => Auth::id(),
        ]);
        return redirect()->route('projects.show', $project)
            ->with('status', 'Section "' . $section->title . '" added to ' . $project->title . '.');
    }





    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectSection $projectSection)
    {

        $project = Project::findOrFail($projectSection->project_id);
        //
        $allSections = ProjectSection::where('project_id', $project->id)->orderBy('order')->get();
        if ($request->edit_position) {
            $validated = $request->validate([
                'edit_position' => 'required|string',
            ]);
            if ($validated['edit_position'] == 'up') {
                //
                $swapping = $allSections->where('order', $projectSection->order - 1)->first();
            } else {
                $swapping = $allSections->where('order', $projectSection->order + 1)->first();
            }
            $sectionChange = $swapping->order;
            $swapping->order = $projectSection->order;
            $projectSection->order = $sectionChange;
            $swapping->save();
            $projectSection->save();
            $message = 'Section "' . $projectSection->title . '" moved ' . $validated['edit_position'] . 'wards';
        } elseif ($request->published) {

            $validated = $request->validate([
                'published' => 'required|string',
            ]);
            $validated['published'] == 'true' ? $projectSection->published = false : $projectSection->published = true;
            $projectSection->save();
            $status = $projectSection->published ? 'published' : 'drafted';
            $message = 'Section "' . $projectSection->title . '" have been ' . $status;
        } else {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'nullable|string',
            ]);
            $projectSection->title = $validated['title'];
            $projectSection->content = $validated['content'];
            $projectSection->last_edited_by = Auth::id();
            $projectSection->save();
            $message = 'Section "' . $projectSection->title . '" edited successfully';
        }
        return redirect()->route('projects.show', $project)
            ->with('status', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectSection $projectSection)
    {
        //
    }
}
