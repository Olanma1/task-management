<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectsController extends Controller
{
    public function createProject()
    {
        return view('projects.create');
    }

    public function saveProject()
    {
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required|max:100',
            'notes' => 'max:255',
        ]);

        $attributes['owner_id'] = auth()->user()->id;

        $project = auth()->user()->project()->create($attributes);

        return redirect('/projects/'. $project->id);
    }

    public function viewOneProject(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    public function getProject()
    {
        $projects = auth()->user()->project;

        return view('projects.index', compact('projects'));
    }

    public function updateProject(Project $project)
    {
        $this->authorize('update', $project);

        request()->validate([
            'notes' => 'required',
        ]);

        $project->update([
            'notes' =>request('notes'),
        ]);
        return redirect('/projects/'. $project->id);
    }
}
