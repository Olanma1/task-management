<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $touches = ['project'];

    protected $casts = ['completed' => 'boolean'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($task){
            Activity::create([
                'project_id' => $task->project->id,
                'description' => 'create_task',
            ]);
        });

        static::updated(function ($task){
            if(! $task->completed) return;

            Activity::create([
                'project_id' => $task->project->id,
                'description' => 'completed_task',
            ]);
        });

        static::updated(function ($task){
            if(! $task->completed){
                Activity::create([
                    'project_id' => $task->project->id,
                    'description' => 'incompleted_task',
                ]);
            }
        });

        static::deleted(function ($task){
             Activity::create([
                'project_id' => $task->project->id,
                'description' => 'deleted_task',
            ]);
        });
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function complete()
    {
        return $this->update(['completed' => true]);
    }

    public function incomplete()
    {
        return $this->update(['completed' => false]);
    }
}
