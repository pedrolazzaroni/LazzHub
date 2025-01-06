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
        $this->apiKey = env('GOOGLE_API_KEY');
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

        // Log da resposta da API
        Log::info('Resposta da API Gemini:', ['response' => $response->json()]);

        if (!$response->successful()) {
            Log::error('Resposta da API Gemini: ' . $response->body());
            return null; // Retorna null em caso de erro
        }

        $responseData = $response->json();

        // Extrair o texto da resposta
        if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            $formattedText = $this->formatResponse($responseData['candidates'][0]['content']['parts'][0]['text']);
            return $formattedText;
        }

        Log::error('Formato inesperado da resposta da API Gemini.');
        return null;
    }

    /**
     * Formata o texto da resposta da API para melhor legibilidade.
     *
     * @param string $text
     * @return string
     */
    protected function formatResponse($text)
    {
        // Remover caracteres de escape Unicode, se houver
        $processedText = html_entity_decode($text, ENT_QUOTES, 'UTF-8');

        // Opcional: Adicionar mais formatações conforme necessário
        return $processedText;
    }
}
