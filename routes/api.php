<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductorController;

Route::post('api/login', [AuthController::class, 'login']);

Route::get('api/productores', [ProductorController::class, 'index']);