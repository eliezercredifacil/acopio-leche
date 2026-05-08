<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    protected $fillable = ['nombre'];    

    public function productores()
    {
        return $this->hasMany(Productor::class);
    }
}


