<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resumo extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'materia',
        'curso',
        'nivel',
        'conteudo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
