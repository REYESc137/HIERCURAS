<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoUser extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'tipo_user';

    // Campos asignables masivamente
    protected $fillable = [
        'nombre',
    ];

    // Relación con el modelo User
    public function users()
    {
        return $this->hasMany(User::class, 'tipo_user_id');
    }
}
