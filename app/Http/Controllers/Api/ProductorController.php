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
            ->get([
                'id',
                'nombre'
            ]);

        return response()->json($productores);
    }
}
