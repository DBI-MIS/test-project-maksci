<?php

namespace App\Services;

use App\Models\Task;

class TaskTool
{
    public function pendingTasks(): string
    {
        $tasks = Task::where('status', 'pending')->get();

        if ($tasks->isEmpty()) {
            return 'No pending tasks.';
        }

        return $tasks->map(fn ($t) => "- {$t->task}")
            ->implode("\n");
    }

    public function completedTasks(): string
    {
        $tasks = Task::where('status', 'completed')->get();

        if ($tasks->isEmpty()) {
            return 'No completed tasks.';
        }

        return $tasks->map(fn ($t) => "- {$t->task}")
            ->implode("\n");
    }

    public function dueDate(string $taskName): string
    {
        $task = Task::where('task', 'like', "%{$taskName}%")
            ->first();

        if (! $task) {
            return 'Task not found.';
        }

        return "{$task->task} is due on {$task->due}";
    }
}