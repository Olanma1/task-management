<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function addProjectTask(Request $request, Project $project)
    {
        if(auth()->user()->id !== (int) $project->owner_id){
            abort(403);
        }

        $request->validate([
            'body' => 'required',
        ]);
        $project->addTask(request('body'));

        return redirect('/projects/'. $project->id);
    }

    public function updateProjectTask(Project $project, Task $task)
    {
        if(auth()->user()->id !== (int) $project->owner_id){
            abort(403);
        }
        request()->validate([
            'body' => 'required',
        ]);

        $task->update([
            'body' =>request('body'),
            'completed' => request()->has('completed'),
        ]);
        return redirect('/projects/'. $project->id);
    }
}
