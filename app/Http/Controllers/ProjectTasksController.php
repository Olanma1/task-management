<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function addProjectTask(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $request->validate([
            'body' => 'required',
        ]);
        $project->addTask(request('body'));

        return redirect('/projects/'. $project->id);
    }

    public function updateProjectTask(Project $project, Task $task)
    {
        $this->authorize('update', $task->project);

        request()->validate([
            'body' => 'required',
        ]);

        $task->update([
            'body' => request('body'),
        ]);

        $method = request('completed') ? 'complete' : 'incomplete';
        $task->$method();

        return redirect('/projects/'. $project->id);
    }
}
