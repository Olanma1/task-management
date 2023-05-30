<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
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
        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('created', $activity->description);
            $this->assertNull($activity->changes);
        });
    }

    public function test_updating_project_generates_activity(): void
    {
        $project = Project::factory()->create();
        $originalState = $project->title;

        $project->update(['title' => 'change title']);
        $this->assertCount(2, $project->activity);
        tap($project->activity->last(), function ($activity) use($originalState){
            $this->assertEquals('updated', $activity->description);

            $newState = [
                'before' => ['title' => $originalState],
                'after' => ['title' => 'change title']
            ];
            $this->assertEquals($newState, $activity->changes);
        });
    }

    public function test_creating_project_task_generates_activity(): void
    {
        $project = Project::factory()->create();

        $project->addTask('create task');
        $this->assertCount(2, $project->activity);
        tap($project->activity->last(), function ($activity){
            $this->assertEquals('create_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('create task', $activity->subject->body);
        });


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
        tap($project->activity->last(), function ($activity){
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('project task', $activity->subject->body);
        });
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
        tap($project->activity->last(), function ($activity){
            $this->assertEquals('incompleted_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('project task', $activity->subject->body);
        });
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
