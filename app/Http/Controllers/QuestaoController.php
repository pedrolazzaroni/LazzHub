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
    protected $generatedQuestions = [];  // Array to store generated questions
    protected $correctAnswerOptions = ['A', 'B', 'C', 'D', 'E'];
    protected $similarityThreshold = 0.7; // Threshold for similarity check (70%)

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
            $this->generatedQuestions = []; // Reset the array for this batch

            for ($i = 0; $i < $quantidade; $i++) {
                // Generate question with embedded answer and validate uniqueness
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

                    // Check for similarity with previous questions
                    $isSimilar = $this->isQuestionSimilar($questaoCompleta, $this->generatedQuestions);

                    if ($attempts >= $maxAttempts && $isSimilar) {
                        throw new \Exception('Não foi possível gerar uma questão única após várias tentativas.');
                    }

                } while ($isSimilar && $attempts < $maxAttempts);

                // Add to generated questions array
                $this->generatedQuestions[] = $questaoCompleta;

                if (!$questaoCompleta) {
                    throw new \Exception('Falha ao gerar questão.');
                }

                // Save the combined question and answer
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
    protected function generatePrompt($materia, $conteudo, $nivel, $tipo, $questionNumber, $totalQuestions)
    {
        $tipoDescricao = $tipo === 'multipla_escolha' ? 'Múltipla Escolha' : 'Discursiva/Prática';
        $basePrompt = "Com base nas seguintes informações:\n" .
                     "Matéria: {$materia}\n" .
                     "Conteúdo: {$conteudo}\n" .
                     "Nível: {$nivel}\n" .
                     "Questão {$questionNumber} de {$totalQuestions}\n\n";

        $promptQuestao = $basePrompt .
            "Gere uma questão e sua resposta de {$tipoDescricao}.\n\n";

        if ($tipo === 'multipla_escolha') {
            $correctAnswer = $this->correctAnswerOptions[array_rand($this->correctAnswerOptions)];
            $promptQuestao .= "A questão deve conter SOMENTE o enunciado e as opções de resposta, todas em fonte normal (sem negrito, para que na hora de copiar possa evitar a exibição de dois ** indesejados). Além disso, gere a resposta apropriada para a questãoo.\n\n" .
                "[Enunciado da questão]\n\n" .
                "A) [alternativa]\n" .
                "B) [alternativa]\n" .
                "C) [alternativa]\n" .
                "D) [alternativa]\n" .
                "E) [alternativa]\n\n" .
                "IMPORTANTE: A alternativa {$correctAnswer} deve ser a correta.";
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
