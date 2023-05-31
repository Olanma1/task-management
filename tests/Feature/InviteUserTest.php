<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InviteUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_can_invite_user(): void
    {
        $project = Project::factory()->create();
        $newUser = User::factory()->create();

        $this->actingAs($project->owner)
        ->postJson(route('user-invite-team', parameters: $project->id), [
            'email' => $newUser->email,
        ]);
        $this->assertTrue($project->team->contains($newUser));
    }

    public function test_only_project_owner_can_invite_user()
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
        ->postJson(route('user-invite-team', parameters: $project->id))
        ->assertStatus(403);

        $project->invite($user);

        $this->actingAs($user)
        ->postJson(route('user-invite-team', parameters: $project->id))
        ->assertStatus(403);
    }

    public function test_invited_user_can_update_tasks(): void
    {
        $project = Project::factory()->create();
        $newUser = User::factory()->create();

        $project->invite($newUser);

        $this->actingAs($newUser)
        ->postJson(route('user-add-project-task', parameters: $project->id), $task = [
            'body' => 'First project task',
        ]);
        $this->assertDatabaseHas('tasks', $task);
    }
}
