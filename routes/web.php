<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRoles;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CongresosController;
use App\Http\Controllers\PresentacionesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrganizacionesController;
use App\Http\Controllers\FechasController;

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
Route::middleware(['checkRoles:Administrador'])->prefix('admin')->group(function () {
  Route::get('/', [WelcomeController::class, 'indexAdmin'])->name('admin');

  Route::get('/organizaciones', [OrganizacionesController::class, 'indexAdmin'])->name('admin.organizaciones');
  Route::get('/organizaciones/{organizacion}', [OrganizacionesController::class, 'edit'])->name('admin.organizaciones.edit');
  Route::put('/organizaciones/{organizacion}', [OrganizacionesController::class, 'update'])->name('admin.organizaciones.update');
  Route::post('/organizaciones', [OrganizacionesController::class, 'store'])->name('admin.organizaciones.store');
  Route::delete('/organizaciones/{organizacion}', [OrganizacionesController::class, 'destroy'])->name('admin.organizaciones.destroy');

  Route::get('/congresos', [CongresosController::class, 'indexAdmin'])->name('admin.congresos');
  Route::get('/congresos/{congreso}', [CongresosController::class, 'edit'])->name('admin.congresos.edit');
  Route::put('/congresos/{congreso}', [CongresosController::class, 'update'])->name('admin.congresos.update');
  Route::post('/congresos', [CongresosController::class, 'store'])->name('admin.congresos.store');
  Route::delete('/congresos/{congreso}', [CongresosController::class, 'destroy'])->name('admin.congresos.destroy');

  Route::get('/horario', [FechasController::class, 'horarioPdf'])->name('admin.horario');
});