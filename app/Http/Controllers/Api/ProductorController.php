<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Productor;
use Illuminate\Http\Request;

class ProductorController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'localidad_id' => 'required|integer'
        ]);

        $productores = Productor::where(
            'localidad_id',
            $request->localidad_id
        )
            ->orderBy('nombre')
            ->get()
            ->map(function ($productor) {

                $capturado = \App\Models\Acopio::where(
                    'productor_id',
                    $productor->id
                )
                    ->where(
                        'fecha',
                        now()->format('Y-m-d')
                    )
                    ->exists();

                return [
                    'id' => $productor->id,
                    'nombre' => $productor->nombre,
                    'capturado' => $capturado
                ];
            });

        return response()->json($productores);
    }
}
