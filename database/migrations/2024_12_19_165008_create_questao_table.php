<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questao', function (Blueprint $table) {
            $table->id();
            $table->text('conteudo'); // Conteúdo da questão
            $table->string('materia', 255); // Matéria da questão
            $table->enum('nivel', ['Muito Fácil', 'Fácil', 'Médio', 'Difícil', 'Muito Difícil']); // Nível de dificuldade
            $table->text('gemini_response')->nullable(); // Garantir que permite nulos
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Usuário que criou a questão
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questao');
    }
};
