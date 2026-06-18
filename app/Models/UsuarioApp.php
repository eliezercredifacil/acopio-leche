<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioApp extends Model
{
    protected $table = 'usuarios_app';

    protected $fillable = [
        'nombre',
        'pin',
        'localidad_id',
        'activo'
    ];
}
