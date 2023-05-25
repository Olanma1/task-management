<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_project_generates_activity(): void
    {
        $project = Project::factory()->create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity[0]->description);
    }

    public function test_updating_project_generates_activity(): void
    {
        $project = Project::factory()->create();

        $project->update(['title' => 'change title']);
        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated', $project->activity->last()->description);
    }

    public function test_creating_project_task_generates_activity(): void
    {
        $project = Project::factory()->create();

        $project->addTask('create task');
        $this->assertCount(2, $project->activity);
        $this->assertEquals('create_task', $project->activity->last()->description);
    }

    public function test_completing_project_task_generates_activity(): void
    {
        $user = User::factory()->create();

        $project = Project::factory()->create(['owner_id' => $user->id]);

        $task = $project->addTask('project task');

        $this->actingAs($user)
        ->putJson(route('user-update-project-task', ['project' => $project->id, 'task' => $task->id]), [
            'body' => 'project task',
            'completed' => true,
        ]);
        $this->assertCount(3, $project->activity);
        $this->assertEquals('completed_task', $project->activity->last()->description);
    }

    public function test_an_incomplete_project_task_generates_activity(): void
    {
        $user = User::factory()->create();

        $project = Project::factory()->create(['owner_id' => $user->id]);

        $task = $project->addTask('project task');

        $this->actingAs($user)
        ->putJson(route('user-update-project-task', ['project' => $project->id, 'task' => $task->id]), [
            'body' => 'project task',
            'completed' => true,
        ]);
        $this->assertCount(3, $project->activity);
        $this->putJson(route('user-update-project-task', ['project' => $project->id, 'task' => $task->id]), [
            'body' => 'project task',
            'completed' => false,
        ]);
        $project = $project->refresh();

        $this->assertCount(4, $project->activity);
        $this->assertEquals('incompleted_task', $project->activity->last()->description);
    }

    public function test_deleting_task_generates_activity(): void
    {
        $project = Project::factory()->create();

        $task = $project->addTask('create task');
        $task->delete();

        $this->assertCount(3, $project->activity);
        $this->assertEquals('deleted_task', $project->activity->last()->description);
    }
}
