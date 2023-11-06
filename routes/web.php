<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CongresosController;
use App\Http\Controllers\TalleresController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WelcomeController::class, 'index'])->name('inicio');

Route::get('/congresos', [CongresosController::class, 'index'])->name('congresos');
Route::get('/congresos/{id}', [CongresosController::class, 'show'])->name('congresos.show');

Route::get('/talleres', [TalleresController::class, 'index'])->name('talleres');