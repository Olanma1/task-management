<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;

class ProjectPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Project $project)
    {
        return $user->is($project->owner) || $project->team->contains($user);
    }

    public function manage(User $user, Project $project)
    {
        return $user->is($project->owner);
    }
}
