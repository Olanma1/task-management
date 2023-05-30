<?php

namespace App\Models;

use App\ActivityTrait;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory; use ActivityTrait;

    protected $guarded = [];

    protected $touches = ['project'];

    protected $casts = ['completed' => 'boolean'];

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($task){
            if(! $task->completed) return;
            $task->createActivity('completed_task');
        });

        static::updated(function ($task){
            if(! $task->completed){
                $task->createActivity('incompleted_task');
            }
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
