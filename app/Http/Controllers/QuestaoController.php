<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questao;
use Illuminate\Support\Facades\Auth;

class QuestaoController extends Controller
{
    /**
     * Show the form for creating a new Questao.
     */
    public function create()
    {
        return view('questoes.create');
    }

    /**
     * Store a newly created Questao in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'conteudo' => 'required|string|max:1000',
            'nivel' => 'required|in:Muito Fácil,Fácil,Médio,Difícil,Muito Difícil',
        ]);

        Questao::create([
            'conteudo' => $request->conteudo,
            'nivel' => $request->nivel,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Questão criada com sucesso!');
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
