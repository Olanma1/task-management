<?php

namespace App\Providers;

use App\Models\Task;
use App\Models\Project;
use App\Observers\TaskObserver;
use App\Observers\ProjectsObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Project::observe(ProjectsObserver::class);
        Task::observe(TaskObserver::class);
    }
}
