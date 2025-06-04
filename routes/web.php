<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticulosController;
use App\Http\Controllers\CategoriasController;

// Ruta de inicio que redirige al listado de artículos
Route::get('/', function () {
    return view('dashboard'); // Esto cargará la vista dashboard.blade.php
});

// Rutas resource para Articulos (CRUD completo)
Route::resource('articulos', ArticulosController::class);

// Rutas resource para Categorias (CRUD completo)
Route::resource('categorias', CategoriasController::class);