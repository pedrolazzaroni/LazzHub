<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pergunta;
use Illuminate\Support\Facades\Auth;
use App\Services\GeminiService;

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
        $validated = $request->validate([
            'pergunta' => 'required|string|max:255',
        ]);

        // Construindo o prompt para a API do Gemini
        $prompt = "Por favor, responda a seguinte pergunta: " . $validated['pergunta'];

        // Fazendo a requisição para a API do Gemini usando o GeminiService
        $response = $this->geminiService->generateContent($prompt);

        // Verifique se a resposta foi bem-sucedida
        if ($response) {
            // Acesse o texto da resposta corretamente
            $content = $response['contents'][0]['parts'][0]['text'] ?? 'Resposta não disponível.';

            // Armazenar a pergunta e a resposta no banco de dados
            Pergunta::create([
                'user_id' => Auth::id(),
                'titulo' => $validated['pergunta'],
                'descricao' => $content, // Armazene o texto da resposta aqui
            ]);

            return view('perguntas.result', ['resultado' => $response]); // Redireciona para a nova view com o resultado
        } else {
            return back()->withErrors(['error' => 'Erro ao obter resposta da API.']);
        }
    }

    public function index()
    {
        $perguntas = Pergunta::all(); // Ou use a paginação se preferir
        return view('perguntas.index', compact('perguntas'));
    }
}
