<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UsuarioApp;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'pin' => 'required|string|size:4'
        ]);

        $usuario = UsuarioApp::where('pin', $request->pin)
            ->where('activo', true)
            ->first();

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'PIN incorrecto'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'usuario' => [
                'id' => $usuario->id,
                'nombre' => $usuario->nombre,
                'localidad_id' => $usuario->localidad_id,
                'localidad' => $usuario->localidad->nombre
            ]
        ]);
    }
}