<?php

namespace App\Concerns;

use App\Models\History;

trait RecordsHistory
{
    protected static function bootRecordsHistory()
    {
        // CREATE
        static::created(function ($task) {
            self::recordHistory($task, 'created');
        });

        // UPDATE
        static::updating(function ($task) {
            self::recordHistory($task, 'updated', $task->getOriginal(), $task->getDirty());
        });

        // DELETE
        static::deleted(function ($task) {
            self::recordHistory($task, 'deleted', $task->getOriginal());
        });
    }

    protected static function recordHistory($task, $action, $old = null, $new = null)
    {
        History::create([
            'task_id' => $task->id,
            'action' => $action,
            'old' => $old ? json_encode($old) : null,
            'new' => json_encode($task->toArray()) ,
        ]);
    }

    public function histories()
    {
        return $this->hasMany(History::class, 'task_id')->where('task', class_basename($this));
    }
}
