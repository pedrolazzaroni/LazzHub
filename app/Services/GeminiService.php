<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.google.api_key');
    }

    public function generateContent($prompt)
    {
        $url = $this->baseUrl . '?key=' . $this->apiKey;

        $response = Http::post($url, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'topK' => 40,
                'topP' => 0.95,
                'maxOutputTokens' => 2048,
            ]
        ]);

        if (!$response->successful()) {
            Log::error('Resposta da API Gemini: ' . $response->body());
            throw new \Exception('Erro na chamada da API Gemini: ' . $response->body());
        }

        $responseData = $response->json();

        if (empty($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            Log::error('Resposta vazia da API Gemini: ' . json_encode($responseData));
            throw new \Exception('Resposta vazia da API Gemini');
        }

        $text = $responseData['candidates'][0]['content']['parts'][0]['text'];

        // Remove asteriscos duplos
        $text = str_replace('**', '', $text);

        // Formata o texto para melhor legibilidade
        $text = $this->formatText($text);

        return $text;
    }

    protected function formatText($text)
    {
        // Remove espaços extras
        $text = preg_replace('/\s+/', ' ', $text);

        // Garante que cada tópico comece em uma nova linha
        $text = preg_replace('/(\d+\.)/', "\n$1", $text);

        // Adiciona espaço após pontuação
        $text = preg_replace('/([.!?])(\w)/', '$1 $2', $text);

        // Remove linhas vazias extras
        $text = preg_replace("/[\r\n]+/", "\n", $text);

        // Remove espaços no início e fim
        $text = trim($text);

        return $text;
    }
}
