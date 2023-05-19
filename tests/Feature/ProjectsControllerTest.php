<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsControllerTest extends TestCase
{
    use WithFaker; use RefreshDatabase;

    public function test_user_can_create_project(): void
    {
        $user = User::factory()->create();

        $attributes = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
        ];

        $this->ActingAs($user)->postJson(route('user-project'), $attributes)
            ->assertRedirect(route('user-get-project'));

        $this->assertDatabaseHas('projects', $attributes);
        $this->getJson(route('user-get-project'))->assertSee($attributes['title']);
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
}
