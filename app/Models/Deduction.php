<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    protected $fillable = [

        'productor_id',

        'localidad_id',

        'semana_inicio',

        'tipo',

        'monto',

        'descripcion',
    ];
}
