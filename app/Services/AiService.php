<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AiService
{
    public function ask(string $message)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('OPENAI_BASE_URL') . '/chat/completions', [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => [
                ['role' => 'user', 'content' => $message]
            ]
        ]);

        return $response->json()['choices'][0]['message']['content'] ?? null;
    }
}