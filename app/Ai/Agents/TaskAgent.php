<?php

namespace App\Ai\Agents;

use App\Services\TaskTool;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

class TaskAgent implements Agent, Conversational, HasTools
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): string
    {
        return <<<TEXT
            You are a friendly task assistant.

            You help users:
            - view pending tasks
            - view completed tasks
            - view all tasks
            - check due dates of tasks
            - guide to create or add new tasks

            RULES:
            - NEVER guess tasks
            - NEVER invent data
            - ALWAYS use tools for real data
            - Be short, friendly, and helpful
            TEXT;
    }

    /**
     * Get the list of messages comprising the conversation so far.
     *
     * @return Message[]
     */
    public function messages(): iterable
    {
        return [];
    }

    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
   public function tools(): iterable
    {
        return [
            new TaskTool(),
        ];
    }
}
