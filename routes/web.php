<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;

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

Route::get('/portfolios', [PortfolioController::class, 'index']) ->name('portfolios.index');
Route::get('/portfolios/create', [PortfolioController::class, 'create']) ->name('portfolios.create');
Route::post('/portfolios', [PortfolioController::class, 'store']) ->name('portfolios.store');
Route::get('/portfolios/{portfolio}', [PortfolioController::class, 'show']) ->name('portfolios.show');
Route::get('/portfolios/{portfolio}/edit', [PortfolioController::class, 'edit']) ->name('portfolios.edit');
Route::put('/portfolios/{portfolio}', [PortfolioController::class, 'update']) ->name('portfolios.update');
Route::delete('/portfolios/{portfolio}', [PortfolioController::class, 'destroy']) ->name('portfolios.destroy');