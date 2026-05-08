<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acopio extends Model
{
    //
    public function productor()
    {
        return $this->belongsTo(Productor::class);
    }
}
