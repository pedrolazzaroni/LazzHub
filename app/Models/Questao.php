<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questao extends Model
{
    use HasFactory;

    protected $table = 'questao';

    protected $fillable = [
        'conteudo',
        'materia',
        'nivel',
        'user_id',
        'gemini_response',
    ];

    /**
     * Get the user that owns the Questao.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
