<?php

use App\Services\TaskTool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::post('/chat', function (Request $request, TaskTool $tasks) {

    $message = strtolower($request->input('message'));

$response = Http::withHeaders([
    'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
    'Content-Type' => 'application/json',
])->post(env('OPENAI_BASE_URL') . '/chat/completions', [
    'model' => 'llama-3.3-70b-versatile',
    'messages' => [
       [
        'role' => 'system',
        'content' => '
            You are a friendly AI task assistant.

            You help users:
            - view pending tasks
            - view completed tasks
            - show both pending and completed tasks
            - help create or add new tasks
            - help create or add new types

            You do NOT invent tasks.

            If the user asks for tasks, you will be given real data from the system.

            Always respond in a friendly, conversational tone.
            Keep responses short and helpful.

            RULE: 
            -NEVER create or guess task names.
            -ONLY use provided task list.
            -If empty, say "No tasks found".
        '
        ],
        [
            'role' => 'user',
            'content' => $message
        ]
    ]
]);

$reply = $response->json()['choices'][0]['message']['content'] ?? '';

if (
    str_contains($message, 'due date') ||
    str_contains($message, 'when is')
) {

    $search = str_replace([
        'what is the due date of',
        'when is the due date of',
        'when is',
        'due date of',
        'due date',
    ], '', $message);

    $search = trim($search);

    $task = \App\Models\Task::where('task', 'like', "%{$search}%")
        ->first();

    return [
        'reply' => $task
            ? "📅 '{$task->task}' is due on {$task->due}"
            : "I couldn't find that task."
    ];
}


if (
    str_contains($message, 'both') ||
    (
        str_contains($message, 'pending') &&
        str_contains($message, 'completed')
    )
) {

    $pending = $tasks->pendingTasks();
    $completed = $tasks->completedTasks();

    $pendingList = $tasks->pendingTasks();
    $completedList = $completed;

    return [
        'reply' =>
            "Pending Tasks:\n" .
            ($pendingList ?: "No pending tasks") .
            "\n\n" .
            "Completed Tasks:\n" .
            ($completedList ?: "No completed tasks")
    ];
}

if (str_contains($message, 'pending')) {

    $data = $tasks->pendingTasks();

    return [
        'reply' => empty($data)
            ? "You're all caught up! No pending tasks."
            : "Here are your pending tasks:\n" . $data
    ];
}

if (str_contains($message, 'completed')) {

    $data = $tasks->completedTasks();

    return [
        'reply' => empty($data)
            ? "No completed tasks yet."
            : "✅ Here are your completed tasks:\n" . $data
    ];
}

if (
    str_contains($message, 'tasks') ||
    str_contains($message, 'task list') ||
    str_contains($message, 'show tasks')
) {

    $pending = $tasks->pendingTasks();
    $completed = $tasks->completedTasks();

    $pendingList = $tasks->pendingTasks();

    $completedList = $completed;

    return [
        'reply' =>
            "📋 Task List\n\n" .

            "Pending Tasks:\n" .
            ($pendingList ?: "No pending tasks") .

            "\n\nCompleted Tasks:\n" .
            ($completedList ?: "No completed tasks")
    ];
}

$responseText = $response->json()['choices'][0]['message']['content'] ?? '';

return [
    'reply' => $responseText
];
});