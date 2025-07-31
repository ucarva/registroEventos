<?php

use App\Http\Controllers\admin\AsistenteController;
use App\Http\Controllers\admin\CategoriaController;
use App\Http\Controllers\admin\CuponController;
use App\Http\Controllers\admin\EntradaController;
use App\Http\Controllers\admin\EventoController;

use App\Http\Controllers\admin\InscripcionController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::resource('asistentes', AsistenteController::class);
Route::resource('eventos', EventoController::class);
Route::resource('categorias', CategoriaController::class);

Route::resource('cupones', CuponController::class)->parameters([
    'cupones' => 'cupon',
]);
Route::resource('inscripciones', InscripcionController::class)->parameters([
    'inscripciones' => 'inscripcion',
]);

Route::post('inscripciones/calcular-valor', [InscripcionController::class, 'calcularValorEntrada'])
    ->name('inscripciones.calcular');

Route::post('/inscripciones/validar-cupon', [InscripcionController::class, 'validarCupon'])
    ->name('inscripciones.validar-cupon');




