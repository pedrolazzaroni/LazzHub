<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pergunta extends Model
{
    use HasFactory;

    // Defina a tabela associada, se o nome não seguir a convenção plural
    protected $table = 'perguntas';

    // Defina os atributos que podem ser preenchidos em massa
    protected $fillable = [
        'user_id',
        'titulo',
        'descricao',
    ];

    // Defina a relação com o modelo User (se aplicável)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 
