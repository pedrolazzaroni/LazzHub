<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questao;
use Illuminate\Support\Facades\Auth;
use App\Services\GeminiService; // Assumindo que há um serviço para interagir com Gemini
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class QuestaoController extends Controller
{
    /**
     * Show the form for creating a new Questao.
     */
    public function create()
    {
        // Add debug to verify method is being called
        \Log::info('QuestaoController@create method called');
        return view('questoes.create');
    }

    /**
     * Store a newly created Questao(s) in storage.
     */
    public function store(Request $request, GeminiService $geminiService): JsonResponse
    {
        // Log para verificar os dados recebidos na requisição
        \Log::info('Dados da requisição para criar Questao(s):', $request->all());

        // Verificar se 'materia' está presente e não está vazio
        if (!$request->filled('materia')) {
            \Log::error('Campo "materia" está vazio ou ausente.');
            return response()->json(['error' => 'O campo "Matéria" é obrigatório.'], 422);
        }

        $request->validate([
            'conteudo' => 'required|string|max:1000',
            'materia' => 'required|string|max:255',
            'nivel' => 'required|in:Muito Fácil,Fácil,Médio,Difícil,Muito Difícil',
            'quantidade' => 'required|integer|min:1|max:10', // Validação para quantidade
        ]);

        $quantidade = $request->quantidade;
        $questoesCriadas = [];

        DB::beginTransaction();

        try {
            for ($i = 0; $i < $quantidade; $i++) {
                // Criar a Questao
                $questao = Questao::create([
                    'conteudo' => $request->conteudo,
                    'materia' => $request->materia,
                    'nivel' => $request->nivel,
                    'user_id' => Auth::id(),
                ]);

                // Gerar resposta do Gemini para cada Questao
                $geminiResponse = $geminiService->generateResponse($questao);

                if ($geminiResponse) {
                    // Garantir que a resposta seja uma string
                    if (is_array($geminiResponse)) {
                        $geminiResponse = json_encode($geminiResponse);
                    }

                    $questao->update([
                        'gemini_response' => $geminiResponse,
                    ]);
                } else {
                    Log::warning('GeminiService retornou resposta nula para Questao ID:', ['id' => $questao->id]);
                }

                $questoesCriadas[] = $questao->id;
            }

            DB::commit();

            \Log::info('Questao(s) criada(s) com IDs:', ['ids' => $questoesCriadas]);

            return response()->json(['ids' => $questoesCriadas], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erro ao criar Questao(s):', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Não foi possível criar as questões.'], 500);
        }
    }

    /**
     * Display the specified Questao.
     */
    public function show($id)
    {
        $questao = Questao::findOrFail($id);

        return view('questoes.show', compact('questao'));
    }
}
