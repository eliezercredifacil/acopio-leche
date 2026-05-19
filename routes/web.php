<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocalidadController;
use App\Http\Controllers\ProductorController;
use App\Http\Controllers\AcopioController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/localidad', [LocalidadController::class, 'index'])->name('localidad')->middleware('auth');
Route::get('/localidad-agregar', [LocalidadController::class, 'create'])->name('localidad.agregar')->middleware('auth');
Route::get('/localidad-editar/{localidad}', [LocalidadController::class, 'edit'])->name('localidad.editar')->middleware('auth');


Route::get('/productor/{ultimoId?}', [ProductorController::class, 'index'])->name('productor')->middleware('auth');
Route::get('/productor-agregar', [ProductorController::class, 'create'])->name('productor.agregar')->middleware('auth');
Route::get('/productor-editar/{productor}', [ProductorController::class, 'edit'])->name('productor.editar')->middleware('auth');

Route::get('/acopio', [AcopioController::class, 'index'])->name('acopio')->middleware('auth');
Route::get('/acopio/resumen-semanal', [AcopioController::class, 'resumenSemanal'])->name('acopio.resumen-semanal')->middleware('auth');

Route::view('profile', 'profile')->middleware(['auth'])->name('profile');

require __DIR__ . '/auth.php';
