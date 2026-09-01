<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\UserController;


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

Route::get('/user', [UserController::class, 'index'])->name('user.index'); // Tampilkan semua kategori
Route::get('/user/create', [UserController::class, 'create'])->name('user.create'); // Form tambah kategori
Route::post('/user', [UserController::class, 'store'])->name('user.store'); // Simpan kategori baru
Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit'); // Form edit kategori
Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update'); // Update kategori
Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy'); // Hapus kategori

