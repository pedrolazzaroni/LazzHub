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

            $prompt = "Por favor, responda a seguinte pergunta: " . $validated['pergunta'] .
                     " na sua resposta, utilize um estilo " . $validated['estilo'];

            $response = $this->geminiService->generateContent($prompt);

            if (!$response) {
                throw new \Exception('Falha ao gerar resposta.');
            }

            Log::info('Resposta da API:', ['response' => $response]);

            $pergunta = Pergunta::create([
                'user_id' => Auth::id(),
                'titulo' => $validated['pergunta'],
                'descricao' => $response,
                'estilo' => $validated['estilo'],
            ]);

            return response()->json([
                'success' => true,
                'id' => $pergunta->id,
                'content' => $response
            ]);

        } catch (\Exception $e) {
            Log::error('Erro ao processar requisição: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'error' => 'Erro ao gerar resposta: ' . $e->getMessage()
            ], 500);
        }
    }

    public function resultado($id)
    {
        $pergunta = Pergunta::findOrFail($id);
        return view('perguntas.result', ['pergunta' => $pergunta]);
    }
}
