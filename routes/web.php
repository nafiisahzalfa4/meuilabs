<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;


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



Route::get('/project', [ProjectController::class, 'index'])->name('project.index'); // Tampilkan semua project
Route::get('/project/create', [ProjectController::class, 'create'])->name('project.create'); // Form tambah project
Route::post('/project', [ProjectController::class, 'store'])->name('project.store'); // Simpan project baru
Route::get('/project/{id}/edit', [ProjectController::class, 'edit'])->name('project.edit'); // Form edit project
Route::put('/project/{id}', [ProjectController::class, 'update'])->name('project.update'); // Update project
Route::delete('/project/{id}', [ProjectController::class, 'destroy'])->name('project.destroy'); // Hapus project
