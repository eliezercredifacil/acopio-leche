<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductorController;

Route::post('/login', [AuthController::class, 'login']);

Route::get('/productores', [ProductorController::class, 'index']);