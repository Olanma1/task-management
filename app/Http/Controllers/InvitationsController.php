<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;

class InvitationsController extends Controller
{
    public function inviteUserToProject(Project $project)
    {
        $this->authorize('manage', $project);

        request()->validate([
                'email' =>'exists:users,email',
            ],
            [
                'email.exists' => 'This email must exist on the app',
        ]);
        $user = User::whereEmail(request('email'))->first();

        $project->invite($user);

        return redirect('/projects/'. $project->id);
    }
}
