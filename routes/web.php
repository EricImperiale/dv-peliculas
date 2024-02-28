<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ConfirmAgeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\MovieReservationController;

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

Route::get('/', [HomeController::class, 'home'])
    ->name('home');

/*
 |--------------------------------------------------------------------------
 | Autenticación
 |--------------------------------------------------------------------------
 */
Route::get('iniciar-sesion', [AuthController::class, 'formLogin'])
    ->name('auth.formLogin');
Route::post('iniciar-sesion', [AuthController::class, 'processLogin'])
    ->name('auth.processLogin');
Route::get('crear-cuenta', [AuthController::class, 'formRegister'])
    ->name('auth.formRegister');
Route::post('crear-cuenta', [AuthController::class, 'processRegister'])
    ->name('auth.processRegister');
Route::post('cerrar-sesion', [AuthController::class, 'processLogout'])
    ->name('auth.processLogout');

/*
 |--------------------------------------------------------------------------
 | Películas
 |--------------------------------------------------------------------------
 */
Route::get('peliculas/listado', [MoviesController::class, 'index'])
    ->name('movies.index');
Route::get('peliculas/nueva', [MoviesController::class, 'formNew'])
    ->name('movies.formNew')
    ->middleware(['auth', 'verificar-rol']);
Route::post('peliculas/nueva', [MoviesController::class, 'processNew'])
    ->name('movies.processNew')
    ->middleware(['auth', 'verificar-rol']);
Route::get('peliculas/{id}', [MoviesController::class, 'view'])
    ->name('movies.view')
    ->middleware(['mayoria-de-edad']);
Route::get('peliculas/{id}/confirmar-edad', [ConfirmAgeController::class, 'formConfirmation'])
    ->name('confirm-age.formConfirmation');
Route::post('peliculas/{id}/confirmar-edad', [ConfirmAgeController::class, 'processConfirmation'])
    ->name('confirm-age.processConfirmation');
Route::get('peliculas/{id}/editar', [MoviesController::class, 'formUpdate'])
    ->name('movies.formUpdate')
    ->middleware(['auth', 'verificar-rol']);
Route::post('peliculas/{id}/editar', [MoviesController::class, 'processUpdate'])
    ->name('movies.processUpdate')
    ->middleware(['auth', 'verificar-rol']);
Route::get('peliculas/{id}/eliminar', [MoviesController::class, 'confirmDelete'])
    ->name('movies.confirmDelete')
    ->middleware(['auth', 'verificar-rol']);
Route::post('peliculas/{id}/eliminar', [MoviesController::class, 'processDelete'])
    ->name('movies.processDelete')
    ->middleware(['auth', 'verificar-rol']);
Route::post('peliculas/{id}/reservar', [MovieReservationController::class, 'processReservation'])
    ->name('movies.processReservation')
    ->middleware(['auth']);

/*
 |--------------------------------------------------------------------------
 | Admin
 |--------------------------------------------------------------------------
 */
Route::get('admin', [AdminController::class, 'dashboard'])
    ->name('admin.dashboard')
    ->middleware(['auth', 'verificar-rol']);

/*
 |--------------------------------------------------------------------------
 | 404
 |--------------------------------------------------------------------------
 */
Route::fallback(function () {
    return view('home');
});
