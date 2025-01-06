<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('GOOGLE_API_KEY');
        $this->baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent';
    }

    public function generateContent(string $prompt): ?string
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $responseData = $response->json();

                if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                    return $this->formatResponse($responseData['candidates'][0]['content']['parts'][0]['text']);
                }
            }

            Log::error('Gemini API Error:', ['response' => $response->body()]);
            return null;

        } catch (\Exception $e) {
            Log::error('Gemini API Exception:', ['message' => $e->getMessage()]);
            return null;
        }
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
