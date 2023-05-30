<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\Generator\Parameter;

class ProjectsControllerTest extends TestCase
{
    use WithFaker; use RefreshDatabase;

    public function test_user_can_create_project(): void
    {
        $user = User::factory()->create();

        $attributes = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->sentence(),
            'notes' => $this->faker->paragraph(),
        ];

        $response = $this->ActingAs($user)->postJson(route('user-project'), $attributes);
        $project = Project::where($attributes)->first();

        $response->assertRedirect(route('user-view-one-project', parameters: $project->id));

        $this->assertDatabaseHas('projects', $attributes);
        $this->getJson(route('user-view-one-project', parameters: $project->id ))
        ->assertSee($attributes['title'])
        ->assertSee($attributes['notes']);
    }

    public function test_it_returns_403_for_non_owner_user(): void
    {
        $user = User::factory()->create();

        $project = Project::factory()->create();

        $response = $this->actingAs($user)
        ->getJson(route('user-view-one-project', parameters: $project->id));

        $response->assertStatus(403);
    }

    public function test_project_belongs_to_the_owner(): void
    {
        $project = Project::factory()->create();

        $this->assertInstanceOf(User::class, $project->owner);

    }

    public function test_user_can_update_their_project(): void
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();

        $project = Project::factory()->create(['owner_id' => $user->id]);

        $this->actingAs($user)
        ->putJson(route('user-update-project', parameters: $project->id), [
            'title' => 'title updated',
            'description' => 'description updated',
            'notes' => 'Note updated',
        ]);

        $this->assertDatabaseHas('projects', [
            'notes' => 'Note updated',
            'title' => 'title updated',
            'description' => 'description updated',
        ]);

    }

    public function test_user_can_delete_project(): void
    {
        $user = User::factory()->create();

        $project = Project::factory()->create(['owner_id' => $user->id]);
        $response = $this->ActingAs($user)->deleteJson(route('user-delete-project', parameters: $project->id));

        $response->assertRedirect(route('user-get-project'));

        $this->assertDatabaseMissing('projects', [$project]);
    }

    public function test_unauthorized_user_can_not_delete_project(): void
    {
        $user = User::factory()->create();

        $project = Project::factory()->create(['owner_id' => $user->id]);
        $response = $this->deleteJson(route('user-delete-project', parameters: $project->id));

        $response->assertStatus(401);
    }
}
