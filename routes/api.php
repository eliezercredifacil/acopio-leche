<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductorController;
use App\Http\Controllers\Api\AcopioController;

Route::post('login', [AuthController::class, 'login']);

Route::get('productores', [ProductorController::class, 'index']);

Route::post('acopio', [AcopioController::class, 'store']);

Route::get('acopio', [AcopioController::class, 'show']);

Route::get('fecha', function () {

    return response()->json([
        'fecha' => now()->format('Y-m-d')
    ]);

});
