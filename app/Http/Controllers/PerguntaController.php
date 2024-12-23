<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pergunta;
use Illuminate\Support\Facades\Auth;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Log;

class PerguntaController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function create()
    {
        return view('perguntas.create');
    }

    public function ask(Request $request)
    {
        try {
            Log::info('Recebendo requisição:', $request->all());

            $validated = $request->validate([
                'pergunta' => 'required|string|max:255',
                'estilo' => 'required|string',
            ]);

            $prompt = "Por favor, responda a seguinte pergunta: " . $validated['pergunta'] . " na sua resposta, utilize um estilo " . $validated['estilo'];
            $response = $this->geminiService->generateContent($prompt);

            Log::info('Resposta da API:', $response);

            // Verifica se a resposta tem a estrutura esperada
            if (isset($response['candidates'][0]['content']['parts'][0]['text'])) {
                $content = $response['candidates'][0]['content']['parts'][0]['text'];

                $pergunta = Pergunta::create([
                    'user_id' => Auth::id(),
                    'titulo' => $validated['pergunta'],
                    'descricao' => $content,
                    'estilo' => $validated['estilo'],
                ]);

                return response()->json([
                    'success' => true,
                    'id' => $pergunta->id,
                    'content' => $content,
                ]);
            }

            Log::error('Estrutura da resposta inválida:', ['response' => $response]);
            return response()->json([
                'success' => false,
                'error' => 'Erro ao processar resposta da API'
            ], 500);

        } catch (\Exception $e) {
            Log::error('Erro ao processar requisição: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Erro interno do servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function resultado($id)
    {
        $pergunta = Pergunta::findOrFail($id);
        return view('perguntas.result', ['pergunta' => $pergunta]);
    }
}
