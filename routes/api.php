<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerguntaController;

Route::post('/generate-response', [PerguntaController::class, 'generateResponse'])->name('pergunta.generateResponse');
