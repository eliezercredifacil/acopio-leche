<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Productor extends Model
{
    use Searchable;

    public function makeAllSearchableUsing($query)
    {
        return $query->with('localidad');
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'localidad' => $this->localidad?->nombre ?? null, // campo para filtrar
        ];
    }

    // Configurar índice de Meilisearch
    public function searchableAs()
    {
        return 'productores';
    }

    public function localidad()
    {
        return $this->belongsTo(Localidad::class);
    }

    public function acopios()
    {
        return $this->hasMany(Acopio::class);
    }

    public function deductions()
    {
        return $this->hasMany(Deduction::class);
    }
}
