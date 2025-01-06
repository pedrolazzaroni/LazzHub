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
                // Passar o parâmetro 'tipo' ao chamar generatePrompt
                $prompt = $this->generatePrompt($request->materia, $request->conteudo, $request->nivel, $request->tipo);
                \Log::info('Prompt gerado para Gemini:', ['prompt' => $prompt]);

                $geminiResponse = $this->geminiService->generateContent($prompt);

                if (!$geminiResponse) {
                    throw new \Exception('Falha ao gerar conteúdo com a API do Gemini.');
                }

                \Log::info('Resposta formatada do Gemini:', ['response' => $geminiResponse]);

                // Supondo que a resposta da API Gemini retorna a questão e a resposta separadas por um delimitador, por exemplo, "\nResposta: "
                $responseParts = explode("\nResposta: ", $geminiResponse);
                $questaoGerada = $responseParts[0];
                $respostaGerada = isset($responseParts[1]) ? $responseParts[1] : '';

                // Criar a Questao com a resposta do Gemini
                $questao = Questao::create([
                    'conteudo' => $request->conteudo,
                    'materia' => $request->materia,
                    'nivel' => $request->nivel,
                    'tipo' => $request->tipo, // Salvar o tipo da questão
                    'user_id' => Auth::id(),
                    'gemini_response' => $questaoGerada, // Salvar a questão gerada
                    'resposta' => $respostaGerada, // Salvar a resposta gerada
                ]);

                \Log::info('Questao criada com ID ' . $questao->id);

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
        $instrucoes = $tipo === 'multipla_escolha'
            ? "Retorne SOMENTE a pergunta e as opções de resposta."
            : "Retorne SOMENTE a pergunta.";

        // Modificação do prompt para solicitar também a resposta
        $instrucoesResposta = $tipo === 'multipla_escolha'
            ? "Além disso, forneça a resposta correta para a questão de múltipla escolha."
            : "Além disso, forneça a resposta para a questão discursiva.";

        return "Crie uma questão de prova do tipo '{$tipoDescricao}' sobre o seguinte conteúdo:\n\nMatéria: {$materia}\nConteúdo: {$conteudo}\nNível de Dificuldade: {$nivel}\n\nInstruções:\n{$instrucoes}\n{$instrucoesResposta}";
    }
}
