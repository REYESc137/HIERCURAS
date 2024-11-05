<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recetas extends Model
{
    protected $table = 'recetas';

    protected $fillable = [
        'nombre',
        'ingredientes',
        'preparacion',
        'tiempo_preparacion',
        'foto',
        'dificultad_id',
        'planta_id'
    ];

    public function dificultad()
    {
        return $this->belongsTo(Dificultades::class, 'dificultad_id');
    }

    public function planta()
{
    return $this->belongsTo(Plantas::class, 'planta_id');
}


}
