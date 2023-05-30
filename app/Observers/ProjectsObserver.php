<?php

namespace App\Observers;

use App\Models\Project;

class ProjectsObserver
{
    /**
     * Handle the Project "created" event.
     */
    public function created(Project $project): void
    {
        $project->createActivity('created');

    }

    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project): void
    {
        $project->createActivity('updated');
    }

    /**
     * Handle the Project "deleted" event.
     */
    // public function deleted(Project $project): void
    // {
    //     $project->createActivity('deleted');
    // }
}
