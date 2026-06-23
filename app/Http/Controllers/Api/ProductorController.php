<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Productor;
use App\Models\Acopio;
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

                $acopio = Acopio::where(
                    'productor_id',
                    $productor->id
                )
                    ->where(
                        'fecha',
                        now()->format('Y-m-d')
                    )
                    ->first();

                return [
                    'id' => $productor->id,
                    'nombre' => $productor->nombre,
                    'capturado' => $acopio !== null,
                    'litros' => $acopio?->litros
                ];
            });

        return response()->json($productores);
    }
}
