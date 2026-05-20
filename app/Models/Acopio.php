<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acopio extends Model
{
    protected $fillable = [
        'productor_id',
        'localidad_id',
        'fecha',
        'litros',
        'precio',
        'total',
        'tipo_semana',
    ];


    public function productor()
    {
        return $this->belongsTo(Productor::class);
    }
}
