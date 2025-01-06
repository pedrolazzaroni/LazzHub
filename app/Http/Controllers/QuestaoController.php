<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Services\GeminiService;

class QuestaoController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

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
    public function store(Request $request): JsonResponse
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
            'tipo' => 'required|in:multipla_escolha,discurssiva', // Validação para o novo campo
        ]);

        $quantidade = $request->quantidade;
        $questoesCriadas = [];

        DB::beginTransaction();

        try {
            for ($i = 0; $i < $quantidade; $i++) {
                // Generate prompts separately for question and answer
                $prompts = $this->generatePrompt($request->materia, $request->conteudo, $request->nivel, $request->tipo);
                \Log::info('Prompts gerados:', $prompts);

                // First generate the question
                $questaoGerada = $this->geminiService->generateContent($prompts['questao']);
                if (!$questaoGerada) {
                    throw new \Exception('Falha ao gerar questão.');
                }
                \Log::info('Questão gerada:', ['questao' => $questaoGerada]);

                // Then generate the answer based on the generated question
                $promptResposta = $this->generateAnswerPrompt($questaoGerada, $request->tipo);
                $respostaGerada = $this->geminiService->generateContent($promptResposta);
                if (!$respostaGerada) {
                    throw new \Exception('Falha ao gerar resposta.');
                }
                \Log::info('Resposta gerada:', ['resposta' => $respostaGerada]);

                // Save both question and answer
                $questao = Questao::create([
                    'conteudo' => $request->conteudo,
                    'materia' => $request->materia,
                    'nivel' => $request->nivel,
                    'tipo' => $request->tipo,
                    'user_id' => Auth::id(),
                    'gemini_response' => $questaoGerada, // Full question text
                    'resposta' => $respostaGerada      // The correct answer
                ]);

                $questoesCriadas[] = $questao->id;
            }

            DB::commit();
            return response()->json(['ids' => $questoesCriadas], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erro ao criar questão:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Falha ao gerar questão: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified Questao(s).
     */
    public function show($ids)
    {
        // Dividir os IDs separados por vírgula
        $idArray = explode(',', $ids);

        // Buscar as Questões correspondentes
        $questoes = Questao::whereIn('id', $idArray)->get();

        if ($questoes->isEmpty()) {
            abort(404, 'Questões não encontradas.');
        }

        return view('questoes.show', compact('questoes'));
    }

    /**
     * Gerar o prompt para a API do Gemini.
     */
    protected function generatePrompt($materia, $conteudo, $nivel, $tipo)
    {
        $tipoDescricao = $tipo === 'multipla_escolha' ? 'Múltipla Escolha' : 'Discursiva/Prática';

        return [
            'questao' => "Gere uma questão de {$tipoDescricao} sobre:\n" .
                        "Matéria: {$materia}\n" .
                        "Conteúdo: {$conteudo}\n" .
                        "Nível: {$nivel}\n\n" .
                        ($tipo === 'multipla_escolha' ?
                            "Formate com: \nPergunta\nA) opção\nB) opção\nC) opção\nD) opção\nE) opção" :
                            "Formate somente a pergunta de forma discursiva."),

            'resposta' => "A resposta deve ser " .
                        ($tipo === 'multipla_escolha' ?
                            "somente a letra correta" :
                            "uma explicação completa e detalhada.")
        ];
    }

    protected function generateAnswerPrompt($questao, $tipo)
    {
        return "Para a seguinte questão:\n\n" .
               $questao . "\n\n" .
               "Forneça " .
               ($tipo === 'multipla_escolha' ?
                   "APENAS a letra da alternativa correta." :
                   "a resposta completa e detalhada.");
    }
}
