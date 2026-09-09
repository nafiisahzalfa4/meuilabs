<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/portfolios', [PortofolioController::class, 'index'])->name('portfolios.index'); 
Route::get('/portfolios/create', [PortofolioController::class, 'create'])->name('portfolios.create'); 
Route::post('/portfolios', [PortofolioController::class, 'store'])->name('portfolios.store'); 
Route::get('/portfolios/{id}/edit', [PortofolioController::class, 'edit'])->name('portfolios.edit'); 
Route::put('/portfolios/{id}', [PortofolioController::class, 'update'])->name('portfolios.update'); 
Route::delete('/portfolios/{id}', [PortofolioController::class, 'destroy'])->name('portfolios.destroy'); 
Route::get('/portfolios/{id}', [PortofolioController::class, 'show'])->name('portfolios.show'); 

Route::get('/user', [UserController::class, 'index'])->name('user.index'); // Tampilkan semua user
Route::get('/user/create', [UserController::class, 'create'])->name('user.create'); // Form tambah user
Route::post('/user', [UserController::class, 'store'])->name('user.store'); // Simpan user baru
Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit'); // Form edit user
Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update'); // Update user
Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy'); // Hapus user

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
Route::get('/services/{id}/edit', [ServiceController::class, 'edit'])->name('services.edit');
Route::put('/services/{id}', [ServiceController::class, 'update'])->name('services.update');
Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');
Route::get('/services/{id}', [ServiceController::class, 'show'])->name('services.show');