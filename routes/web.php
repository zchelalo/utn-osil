<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRoles;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CongresosController;
use App\Http\Controllers\PresentacionesController;
use App\Http\Controllers\AuthController;

// RUTAS DE LA APLICACIÓN
Route::get('/', [WelcomeController::class, 'index'])->name('inicio');

Route::get('/congresos', [CongresosController::class, 'index'])->name('congresos');
Route::get('/congresos/{id}', [CongresosController::class, 'show'])->name('congresos.show');

Route::get('/presentaciones', [PresentacionesController::class, 'index'])->name('presentaciones');
Route::get('/presentaciones/{id}', [PresentacionesController::class, 'show'])->name('presentaciones.show');

Route::post('/login', [AuthController::class, 'store'])->name('auth.store')->middleware('guest');
Route::post('/register', [AuthController::class, 'storeUsuario'])->name('auth.store-user')->middleware('guest');
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout')->middleware('checkRoles:Administrador,Presentador,Invitado');

// RUTAS DEL DASHBOARD
Route::get('/admin', [WelcomeController::class, 'indexAdmin'])->name('admin')->middleware('checkRoles:Administrador');