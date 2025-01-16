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
    protected $generatedQuestions = [];
    protected $correctAnswerOptions = ['A', 'B', 'C', 'D', 'E'];
    protected $similarityThreshold = 0.7;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function create()
    {
        Log::info('QuestaoController@create method called');
        return view('questoes.create');
    }

    public function store(Request $request): JsonResponse
    {
        Log::info('Dados da requisição para criar Questao(s):', $request->all());

        if (!$request->filled('materia')) {
            Log::error('Campo "materia" está vazio ou ausente.');
            return response()->json(['error' => 'O campo "Matéria" é obrigatório.'], 422);
        }

        $request->validate([
            'conteudo' => 'required|string|max:1000',
            'materia' => 'required|string|max:255',
            'nivel' => 'required|in:Muito Fácil,Fácil,Médio,Difícil,Muito Difícil',
            'quantidade' => 'required|integer|min:1|max:10',
            'tipo' => 'required|in:multipla_escolha,discurssiva',
        ]);

        $quantidade = $request->quantidade;
        $questoesCriadas = [];

        DB::beginTransaction();

        try {
            $this->generatedQuestions = [];

            for ($i = 0; $i < $quantidade; $i++) {
                $attempts = 0;
                $maxAttempts = 5;

                do {
                    $prompts = $this->generatePrompt(
                        $request->materia,
                        $request->conteudo,
                        $request->nivel,
                        $request->tipo,
                        $i + 1,
                        $quantidade
                    );

                    $questaoCompleta = $this->geminiService->generateContent($prompts['questao']);
                    $attempts++;

                    $isSimilar = $this->isQuestionSimilar($questaoCompleta, $this->generatedQuestions);

                    if ($attempts >= $maxAttempts && $isSimilar) {
                        throw new \Exception('Não foi possível gerar uma questão única após várias tentativas.');
                    }

                } while ($isSimilar && $attempts < $maxAttempts);

                $this->generatedQuestions[] = $questaoCompleta;

                if (!$questaoCompleta) {
                    throw new \Exception('Falha ao gerar questão.');
                }

                $questao = Questao::create([
                    'conteudo' => $request->conteudo,
                    'materia' => $request->materia,
                    'nivel' => $request->nivel,
                    'tipo' => $request->tipo,
                    'user_id' => Auth::id(),
                    'gemini_response' => $questaoCompleta,
                ]);

                $questoesCriadas[] = $questao->id;
            }

            DB::commit();
            return response()->json(['ids' => $questoesCriadas], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao criar questão:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Falha ao gerar questão: ' . $e->getMessage()], 500);
        }
    }
    public function show($ids)
    {
        $idArray = explode(',', $ids);

        $questoes = Questao::whereIn('id', $idArray)->get();

        if ($questoes->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'Você não tem permissão para acessar esta pergunta.');
        }
        if ($questoes->isEmpty()) {
            abort(404, 'Questões não encontradas.');
        }

        return view('questoes.show', compact('questoes'));
    }
    protected function generatePrompt($materia, $conteudo, $nivel, $tipo, $questionNumber, $totalQuestions)
    {
        $tipoDescricao = $tipo === 'multipla_escolha' ? 'Múltipla Escolha' : 'Discursiva/Prática';
        $basePrompt = "Com base nas seguintes informações:\n" .
                     "Matéria: {$materia}\n" .
                     "Conteúdo: {$conteudo}\n" .
                     "Nível: {$nivel}\n" .
                     "Questão {$questionNumber} de {$totalQuestions}\n\n";

        $promptQuestao = $basePrompt .
            "Gere uma questão e sua resposta de {$tipoDescricao}.\n";

        if ($tipo === 'multipla_escolha') {
            $promptQuestao .= "A questão deve conter o seguinte layout:\n".
            "[ENUNCIADO]\n" .
            "A) [alternativa]\n" .
            "B) [alternativa]\n" .
            "C) [alternativa]\n" .
            "D) [alternativa]\n" .
            "E) [alternativa]\n\n".
            "[RESPOSTA CORRETA]\n" .
            "Lembre-se: Não use palavras em negrito, itálico ou sublinhado.";
        }
        return [
            'questao' => $promptQuestao,
        ];
    }

    protected function isQuestionSimilar($newQuestion, $existingQuestions)
    {
        foreach ($existingQuestions as $existing) {
            similar_text(
                strtolower($newQuestion),
                strtolower($existing),
                $percent
            );

            if ($percent > ($this->similarityThreshold * 100)) {
                return true;
            }
        }
        return false;
    }
}
