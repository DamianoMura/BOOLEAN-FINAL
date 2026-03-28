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
    // In ProjectSectionController.php - metodo update modificato
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectSection $projectSection)
    {
        $project = Project::findOrFail($projectSection->project_id);

        if ($request->edit_position) {
            $validated = $request->validate([
                'edit_position' => 'required|string|in:up,down',
            ]);

            // Prendi tutte le sezioni ordinate
            $allSections = ProjectSection::where('project_id', $project->id)
                ->orderBy('order')
                ->get();

            // Trova l'indice della sezione corrente
            $currentIndex = $allSections->search(function ($item) use ($projectSection) {
                return $item->id === $projectSection->id;
            });

            if ($currentIndex === false) {
                return redirect()->route('projects.show', $project)
                    ->with('error', 'Section not found in ordering');
            }

            // Determina il nuovo indice
            if ($validated['edit_position'] == 'up' && $currentIndex > 0) {
                $newIndex = $currentIndex - 1;
            } elseif ($validated['edit_position'] == 'down' && $currentIndex < $allSections->count() - 1) {
                $newIndex = $currentIndex + 1;
            } else {
                return redirect()->route('projects.show', $project)
                    ->with('error', 'Cannot move section further');
            }

            // Crea una collezione per la riorganizzazione
            $sectionsCollection = $allSections->values();

            // Rimuovi la sezione corrente dalla collezione
            $sectionToMove = $sectionsCollection->pull($currentIndex);

            // Inseriscila nella nuova posizione
            $sectionsCollection->splice($newIndex, 0, [$sectionToMove]);

            // Riassegna gli ordini (ora $section è un oggetto modello)
            foreach ($sectionsCollection as $index => $section) {
                $section->order = $index + 1;
                $section->save();
            }

            $message = 'Section "' . $projectSection->title . '" moved ' . $validated['edit_position'];
        } elseif ($request->published) {
            $projectSection->published = !$projectSection->published;
            $projectSection->save();
            $status = $projectSection->published ? 'published' : 'drafted';
            $message = 'Section "' . $projectSection->title . '" has been ' . $status;
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

        // Forza il refresh completo della pagina
        return redirect()->route('projects.show', $project)
            ->with('status', $message)
            ->with('refresh', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $projectSectionId = $request->input('projectSectionId');
        $projectSection = ProjectSection::findOrFail($projectSectionId);
        $project =   Project::findOrFail($projectSection->project_id);
        $title = $projectSection->title;
        $projectSection->delete();
        return redirect()->route('projects.show', $project)->with('status', 'Section "' . $title . '" deleted successfully from ' . $project->title . '.');
    }
}
