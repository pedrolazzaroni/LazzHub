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
            $table->text('conteudo');
            $table->string('materia', 255);
            $table->enum('nivel', ['Muito Fácil', 'Fácil', 'Médio', 'Difícil', 'Muito Difícil']);
            $table->enum('tipo', ['multipla_escolha', 'discurssiva'])->default('discurssiva');
            $table->text('gemini_response')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
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
