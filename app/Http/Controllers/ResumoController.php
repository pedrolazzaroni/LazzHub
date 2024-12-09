<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resumo;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ResumoController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function create()
    {
        return view('resumos.create');
    }

    public function generateResume(Request $request)
    {
        try {
            Log::info('Recebendo requisição:', $request->all());

            $validated = $request->validate([
                'prompt' => 'required|string',
                'materia' => 'required|string|max:50',
                'curso' => 'required|string|max:50',
                'nivel' => 'required|string',
                'conteudo' => 'required|string|max:50',
            ]);

            $prompt = $request->input('prompt');
            Log::info('Prompt gerado:', ['prompt' => $prompt]);

            $response = $this->geminiService->generateContent($prompt);
            Log::info('Resposta da API:', ['response' => $response]);

            // Salvar o resumo no banco de dados
            $resumo = Resumo::create([
                'user_id' => Auth::id(),
                'content' => $response,
                'materia' => $validated['materia'],
                'curso' => $validated['curso'],
                'nivel' => $validated['nivel'],
                'conteudo' => $validated['conteudo']
            ]);

            return response()->json([
                'id' => $resumo->id,
                'content' => $response
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao gerar resumo: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            Log::error('Request data:', $request->all());
            return response()->json([
                'error' => 'Erro ao gerar resumo: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $resumo = Resumo::findOrFail($id);
        return view('resumos.show', compact('resumo'));
    }

    public function historico()
    {
        $resumos = Resumo::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('resumos.historico', compact('resumos'));
    }

    public function save(Request $request)
    {
        try {
            $validated = $request->validate([
                'resumo_id' => 'required|exists:resumos,id',
                'titulo' => 'required|string|max:255'
            ]);

            $resumo = Resumo::findOrFail($validated['resumo_id']);
            $resumo->titulo = $validated['titulo'];
            $resumo->save();

            return response()->json(['message' => 'Resumo salvo com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao salvar resumo'], 500);
        }
    }
}
