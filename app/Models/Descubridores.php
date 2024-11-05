<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Descubridores extends Model
{
    protected $table = 'descubridores';

    protected $fillable = [
        'nombre',
        'pais_id',
        'lugar_nacimiento',
        'expediciones',
        'biografia',
        'foto',
        'fecha_descubrimiento'
    ];

    public function pais()
    {
        return $this->belongsTo(Pais::class);
    }
}
