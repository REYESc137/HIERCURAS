<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarioReceta extends Model
{
    use HasFactory;

    protected $table = 'comentarios_receta';

    protected $fillable = [
        'usuario_id', 'receta_id', 'comentario'
    ];

    // Relación con el modelo Receta
    public function receta()
    {
        return $this->belongsTo(Recetas::class, 'receta_id');
    }

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}

