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

   
    //Relación con la localidad.
    public function localidad()
    {
        return $this->belongsTo(Localidad::class);
    }
}
