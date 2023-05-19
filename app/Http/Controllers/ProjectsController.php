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
            'description' => 'required',
        ]);

        $attributes['owner_id'] = auth()->user()->id;

        auth()->user()->project()->create($attributes);

        return redirect('/projects');
    }

    public function viewOneProject(Project $project)
    {
        if(auth()->user()->id !== (int) $project->owner_id){
            abort(403);
        }

        return view('projects.show', compact('project'));
    }

    public function getProject()
    {
        $projects = auth()->user()->project;

        return view('projects.index', compact('projects'));
    }
}
