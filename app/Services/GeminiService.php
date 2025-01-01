<?php

namespace App\Services;

use App\Models\Questao;
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

        return $response->json(); // Retorna a resposta JSON
    }

    /**
     * Gera uma resposta para a Questao utilizando a API do Gemini.
     *
     * @param Questao $questao
     * @return array|string|null
     */
    public function generateResponse(Questao $questao)
    {
        try {
            // Log para verificar o conteúdo da Questao
            Log::info('Gerando resposta para Questao ID:', ['id' => $questao->id]);

            // Exemplo de chamada à API do Gemini (substitua com a implementação real)
            $response = Http::post('https://api.gemini.com/generate', [
                'conteudo' => $questao->conteudo,
                'materia' => $questao->materia,
                'nivel' => $questao->nivel,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                // Verificar se a estrutura da resposta é válida
                if (isset($data['response']['candidates'][0]['content']['parts'][0]['text'])) {
                    $geminiText = $data['response']['candidates'][0]['content']['parts'][0]['text'];
                    Log::info('Resposta recebida da API do Gemini:', ['resposta' => $geminiText]);
                    return $geminiText;
                } else {
                    Log::error('Estrutura da resposta inválida:', ['response' => $data]);
                    return null;
                }
            } else {
                Log::error('Erro na API do Gemini:', ['status' => $response->status(), 'body' => $response->body()]);
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Exceção ao gerar resposta com Gemini:', [
                'message' => $e->getMessage(),
                'stack' => $e->getTraceAsString()
            ]);
            return null;
        }
    }
}
