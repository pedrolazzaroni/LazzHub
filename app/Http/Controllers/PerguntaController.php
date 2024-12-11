<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerguntaController extends Controller
{
    public function create()
    {
        return view('perguntas.create'); // Retorna a view para criar uma nova pergunta
    }
}
