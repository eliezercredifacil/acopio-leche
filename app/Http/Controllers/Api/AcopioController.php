<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Acopio;
use App\Models\Productor;
use Illuminate\Http\Request;

class AcopioController extends Controller
{
    public function store(Request $request)
    {
        /*
         * Validamos los datos
         * enviados desde Android.
         */
        $request->validate([
            'productor_id' => 'required|integer',
            'fecha'        => 'required|date',
            'litros'       => 'required|numeric|min:0.01'
        ]);

        /*
         * Buscamos el productor.
         */
        $productor = Productor::findOrFail($request->productor_id);

        /*
         * Calculamos el total.
         */
        $precio = $productor->precio_litro;

        $total = $request->litros * $precio;

        /*
         * Guardamos el acopio.
         */
        $acopio = Acopio::create([
            'productor_id' => $productor->id,
            'localidad_id' => $productor->localidad_id,
            'fecha'        => $request->fecha,
            'litros'       => $request->litros,
            'precio'       => $precio,
            'total'        => $total,
            'tipo_semana'  => $productor->semana
        ]);

        return response()->json([
            'ok' => true,
            'id' => $acopio->id
        ]);
    }
}