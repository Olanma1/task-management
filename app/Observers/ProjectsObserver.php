<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\Activity;

class ProjectsObserver
{
    /**
     * Handle the Project "created" event.
     */
    public function created(Project $project): void
    {
        Activity::create([
            'project_id' => $project->id,
            'description' => 'created',
        ]);
    }

    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project): void
    {
        Activity::create([
            'project_id' => $project->id,
            'description' => 'updated',
        ]);
    }

    /**
     * Handle the Project "deleted" event.
     */
    public function deleted(Project $project): void
    {
        Activity::create([
            'project_id' => $project->id,
            'description' => 'deleted_task',
        ]);
    }

    /**
     * Handle the Project "restored" event.
     */
    public function restored(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "force deleted" event.
     */
    public function forceDeleted(Project $project): void
    {
        //
    }
}
