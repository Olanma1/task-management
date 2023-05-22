<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    public function test_projects_can_have_tasks(): void
    {
        $user = User::factory()->create();

        $project = Project::factory()->create(['owner_id' => $user->id]);

        $this->actingAs($user)
        ->postJson(route('user-add-project-task', parameters: $project->id), [
            'body' => 'First project task',
        ]);
        $this->getJson(route('user-view-one-project', parameters: $project->id))->assertSee('First project task');

    }

    public function test_it_returns_403_for_non_project_owner_user(): void
    {
        $user = User::factory()->create();

        $project = Project::factory()->create();

        $response = $this->actingAs($user)
        ->postJson(route('user-add-project-task', parameters: $project->id), [
            'body' => 'First project task',
        ]);
        $response->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body' => 'First project task',]);
    }

    public function test_task_can_be_updated(): void
    {
        $user = User::factory()->create();

        $project = Project::factory()->create(['owner_id' => $user->id]);

        $task = $project->addTask('project task');

        $this->actingAs($user)
        ->putJson(route('user-update-project-task', ['project' => $project->id, 'task' => $task->id]), [
            'body' => 'project task',
            'completed' => true,
        ]);
        $this->assertDatabaseHas('tasks',
        [
            'body' => 'project task',
            'completed' => true,
        ]);
    }

    public function test_it_returns_403_for_non_task_owner(): void
    {
        $user = User::factory()->create();

        $project = Project::factory()->create();

        $task = $project->addTask('project task');

        $response = $this->actingAs($user)
        ->putJson(route('user-update-project-task', ['project' => $project->id, 'task' => $task->id]), [
            'body' => 'First project task',
        ]);
        $response->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body' => 'First project task',]);
    }


}
