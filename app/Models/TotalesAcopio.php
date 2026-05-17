<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TotalesAcopio extends Model
{
    protected $fillable = [

        'localidad_id',

        'fecha',

        'tipo_semana',

        'litros',
    ];
}
