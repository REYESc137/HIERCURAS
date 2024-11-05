<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'pais';

    protected $fillable = [
        'nombre'
    ];

    // Relación con Descubridores
    public function descubridores()
    {
        return $this->hasMany(Descubridores::class);
    }

    // Relación con Plantas (en caso de que se utilice como lugar de origen)

}
