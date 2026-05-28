<?php

namespace App\Ai\Tools;

use App\Services\TaskTool as TaskService;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;

class TaskTool implements Tool
{
    public function __construct(
        protected TaskService $tasks
    ) {}

    public function name(): string
    {
        return 'tasks';
    }

    public function description(): string
    {
        return 'Fetch user tasks including pending, completed, or all tasks with optional due dates.';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'type' => 'object',
            'properties' => [
                'status' => [
                    'type' => 'string',
                    'enum' => ['pending', 'completed', 'all'],
                    'description' => 'Type of tasks to retrieve',
                ],
            ],
            'required' => ['status'],
        ];
    }

    public function handle(Request $request): string
{
    $type = $request->input('type');

    if ($type === 'pending') {
        return $this->tasks->pendingTasks();
    }

    if ($type === 'completed') {
        return $this->tasks->completedTasks();
    }

    return 'Invalid request.';
}
}