<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRoles;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CongresosController;
use App\Http\Controllers\PresentacionesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrganizacionesController;
use App\Http\Controllers\FechasController;
use App\Http\Controllers\TipoPresentacionesController;
use App\Http\Controllers\UsuariosController;

// RUTAS DE LA APLICACIÓN
Route::get('/', [WelcomeController::class, 'index'])->name('inicio');

Route::get('/congresos', [CongresosController::class, 'index'])->name('congresos');
Route::get('/congresos/{id}', [CongresosController::class, 'show'])->name('congresos.show');

Route::get('/presentaciones', [PresentacionesController::class, 'index'])->name('presentaciones');
Route::get('/presentaciones/{id}', [PresentacionesController::class, 'show'])->name('presentaciones.show');

Route::post('/login', [AuthController::class, 'store'])->name('auth.store')->middleware('guest');
Route::post('/register', [AuthController::class, 'storeUsuario'])->name('auth.store-user')->middleware('guest');
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout')->middleware('checkRoles:Administrador,Presentador,Invitado');

Route::get('/horario/{id}', [FechasController::class, 'horarioPdf'])->name('horario');

Route::get('/configuracion', [UsuariosController::class, 'viewConf'])->name('configuracion')->middleware('checkRoles:Administrador,Presentador,Invitado');
Route::put('/configuracion/{usuario}', [UsuariosController::class, 'updateConf'])->name('configuracion.update')->middleware('checkRoles:Administrador,Presentador,Invitado');

Route::get('/perfil/{usuario}', [UsuariosController::class, 'show'])->name('usuarios');

Route::post('/presentacion/taller/inscripcion/{presentacion}', [PresentacionesController::class, 'inscripcion'])->name('inscripcion')->middleware('checkRoles:Invitado');

Route::middleware(['checkRoles:Presentador'])->prefix('modificar')->group(function () {
  Route::get('/presentacion/{presentacion}', [PresentacionesController::class, 'editPresentador'])->name('presentaciones.edit');
  Route::put('/presentacion/{presentacion}', [PresentacionesController::class, 'updatePresentador'])->name('presentaciones.update');
  Route::put('/presentacion/eliminar-presentacion/{presentacion}', [PresentacionesController::class, 'updatePresentacionPresentador'])->name('presentaciones.update-presentacion');
});

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

  Route::get('/tipos-de-presentacion', [TipoPresentacionesController::class, 'indexAdmin'])->name('admin.tipos');
  Route::get('/tipos-de-presentacion/{tipo}', [TipoPresentacionesController::class, 'edit'])->name('admin.tipos.edit');
  Route::put('/tipos-de-presentacion/{tipo}', [TipoPresentacionesController::class, 'update'])->name('admin.tipos.update');
  Route::post('/tipos-de-presentacion', [TipoPresentacionesController::class, 'store'])->name('admin.tipos.store');
  Route::delete('/tipos-de-presentacion/{tipo}', [TipoPresentacionesController::class, 'destroy'])->name('admin.tipos.destroy');

  Route::get('/presentaciones', [PresentacionesController::class, 'indexAdmin'])->name('admin.presentaciones');
  Route::get('/presentaciones/{presentacion}', [PresentacionesController::class, 'edit'])->name('admin.presentaciones.edit');
  Route::put('/presentaciones/{presentacion}', [PresentacionesController::class, 'update'])->name('admin.presentaciones.update');
  Route::post('/presentaciones', [PresentacionesController::class, 'store'])->name('admin.presentaciones.store');
  Route::delete('/presentaciones/{presentacion}', [PresentacionesController::class, 'destroy'])->name('admin.presentaciones.destroy');
  Route::put('/presentaciones/eliminar-presentacion/{presentacion}', [PresentacionesController::class, 'updatePresentacion'])->name('admin.presentaciones.update-presentacion');

  Route::get('/fechas', [FechasController::class, 'indexAdmin'])->name('admin.fechas');
  Route::get('/fechas/{fecha}', [FechasController::class, 'edit'])->name('admin.fechas.edit');
  Route::put('/fechas/{fecha}', [FechasController::class, 'update'])->name('admin.fechas.update');
  Route::post('/fechas', [FechasController::class, 'store'])->name('admin.fechas.store');
  Route::delete('/fechas/{fecha}', [FechasController::class, 'destroy'])->name('admin.fechas.destroy');

  Route::get('/usuarios', [UsuariosController::class, 'indexAdmin'])->name('admin.usuarios');
  Route::get('/usuarios/{usuario}', [UsuariosController::class, 'edit'])->name('admin.usuarios.edit');
  Route::put('/usuarios/{usuario}', [UsuariosController::class, 'update'])->name('admin.usuarios.update');
  Route::post('/usuarios', [UsuariosController::class, 'store'])->name('admin.usuarios.store');
  Route::delete('/usuarios/{usuario}', [UsuariosController::class, 'destroy'])->name('admin.usuarios.destroy');
});