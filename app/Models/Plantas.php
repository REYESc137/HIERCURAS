<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plantas extends Model
{
    protected $table = 'plantas';

    protected $fillable = [
        'nombre_comun',
        'nombre_cientifico',
        'otros_nombres',
        'familia_id',
        'lugar_origen',
        'cientifico_descubridor_id',
        'descripcion',
        'foto',
        'especies_relacionadas_id',
        'uso',
        'estatus'
    ];

    public function familia()
    {
        return $this->belongsTo(Familia::class, 'familia_id');
    }

    public function lugarOrigen()
{
    return $this->belongsTo(Pais::class, 'lugar_origen', 'id');
}







public function especiesRelacionadas()
{
    return $this->belongsTo(EspRelac::class, 'especies_relacionadas_id', 'id');
}


    public function descubridor()
    {
        return $this->belongsTo(Descubridores::class, 'cientifico_descubridor_id');
    }


}

