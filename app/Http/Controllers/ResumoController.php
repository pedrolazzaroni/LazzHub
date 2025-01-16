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
                'conteudo' => 'required|string|max:300',
            ]);

            $prompt = $request->input('prompt');
            Log::info('Prompt gerado:', ['prompt' => $prompt]);

            $response = $this->geminiService->generateContent($prompt);

            if (is_array($response)) {
                $response = json_encode($response);
            }

            Log::info('Resposta da API:', ['response' => $response]);

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

    public function show($id){
        $resumo = Resumo::findOrFail($id);

        if ($resumo->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'Você não tem permissão para acessar esta pergunta.');
        }

        return view('resumos.show', compact('resumo'));
    }

    public function historico()
    {
        $resumos = Resumo::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $questoes = \App\Models\Questao::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $perguntas = \App\Models\Pergunta::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $groupedQuestoes = $questoes->groupBy(function($item) {
            return $item->created_at->format('Y-m-d H:i');
        });

        $groupedPerguntas = $perguntas->groupBy(function($item) {
            return $item->created_at->format('Y-m-d H:i');
        });

        $items = $resumos->concat($groupedQuestoes)->concat($groupedPerguntas)->sortByDesc(function($item) {
            return $item instanceof \Illuminate\Support\Collection ? $item->first()->created_at : $item->created_at;
        });

        $perPage = 9;
        $page = request()->get('page', 1);
        $items = new \Illuminate\Pagination\LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            ['path' => request()->url()]
        );

        return view('resumos.historico', compact('items'));
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
