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

        usleep(300000);
        //sleep(1);

        //Buscamos si ya existe un acopio para este productor en esta fecha.
        $acopio = Acopio::updateOrCreate(

            // Campos para buscar
            [
                'productor_id' => $productor->id,
                'fecha' => $request->fecha
            ],

            // Campos para crear o actualizar
            [
                'localidad_id' => $productor->localidad_id,
                'litros' => $request->litros,
                'precio' => $precio,
                'total' => $total,
                'tipo_semana' => $productor->semana
            ]
        );

        return response()->json([
            'ok' => true,
            'id' => $acopio->id,
            'creado' => $acopio->wasRecentlyCreated
        ]);
    }

    public function show(Request $request)
    {
        $acopio = Acopio::where('productor_id', $request->productor_id)->where('fecha', $request->fecha)->first();

        return response()->json([
            'litros' => $acopio?->litros
        ]);
    }

    public function eliminar(Request $request)
    {
        $request->validate([
            'productor_id' => 'required|integer',
            'fecha' => 'required|date'
        ]);

        Acopio::where(
            'productor_id',
            $request->productor_id
        )
            ->where(
                'fecha',
                $request->fecha
            )
            ->delete();

        return response()->json([
            'ok' => true
        ]);
    }

    
}
