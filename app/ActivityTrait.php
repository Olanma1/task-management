<?php

namespace App;

use App\Models\Activity;
use Illuminate\Support\Arr;

trait ActivityTrait
{

    public $old = [];

    public static function bootActivityTrait()
    {
        static::updating(function ($model) {
            $model->old = $model->getOriginal();
        });
    }

    public function createActivity($description)
    {
        $this->activity()->create([
        'user_id' => ($this->project ?? $this)->owner->id,
        'project_id' => class_basename($this) === 'project' ? $this->id : $this->project_id,
        'description' => $description,
        'changes' => $this->getActivityChanges()

    ]);
    }

    public function getActivityChanges()
    {
        if ($this->wasChanged()){
            return [
                'before' => Arr::except(array_diff($this->old, $this->getAttributes()), 'updated_at'),
                'after' => Arr::except($this->getChanges(), 'updated_at')
            ];
        }
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }
}
