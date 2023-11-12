<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRoles;
use App\Http\Controllers\PresentacionesController;
// use App\Http\Controllers\OrganizacionesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//   return $request->user();
// });

Route::get('/presentaciones', [PresentacionesController::class, 'busqueda']);

// Route::middleware(['auth:sanctum', 'checkRoles:Administrador'])->prefix('admin')->group(function () {
//   Route::get('/organizaciones', [OrganizacionesController::class, 'index']);
// });