<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dificultades extends Model
{
    protected $table = 'dificultades';

    protected $fillable = [
        'nombre'
    ];

    public function recetas()
    {
        return $this->hasMany(Recetas::class);
    }
}
