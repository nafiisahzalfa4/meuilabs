<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});


// Dashboard Super Admin
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'role:admin'])->name('admin.dashboard');


// Dashboard Designer
Route::get('/designer/dashboard', function () {
    return view('designer.dashboard');
})->middleware(['auth', 'role:designer'])->name('designer.dashboard');


// Dashboard Customer
Route::get('/customer/dashboard', function () {
    return view('customer.dashboard');
})->middleware(['auth', 'role:customer'])->name('customer.dashboard');



// ==============================
// AUTHENTICATION / LOGIN
// ==============================

Route::get('/login', [LoginController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.post');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');


// ==============================
// PORTFOLIO
// ==============================

Route::get('/portfolios', [PortofolioController::class, 'index'])
    ->name('portfolios.index');

Route::get('/portfolios/create', [PortofolioController::class, 'create'])
    ->name('portfolios.create');

Route::post('/portfolios', [PortofolioController::class, 'store'])
    ->name('portfolios.store');

Route::get('/portfolios/{portfolio}', [PortofolioController::class, 'show'])
    ->name('portfolios.show');

Route::get('/portfolios/{portfolio}/edit', [PortofolioController::class, 'edit'])
    ->name('portfolios.edit');

Route::put('/portfolios/{portfolio}', [PortofolioController::class, 'update'])
    ->name('portfolios.update');

Route::delete('/portfolios/{portfolio}', [PortofolioController::class, 'destroy'])
    ->name('portfolios.destroy');


// ==============================
// USER
// ==============================

// ==============================
// USER - SUPER ADMIN
// ==============================

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/user', [UserController::class, 'index'])
        ->name('user.index');

    Route::get('/user/create', [UserController::class, 'create'])
        ->name('user.create');

    Route::post('/user', [UserController::class, 'store'])
        ->name('user.store');

    Route::get('/user/{id}/edit', [UserController::class, 'edit'])
        ->name('user.edit');

    Route::put('/user/{id}', [UserController::class, 'update'])
        ->name('user.update');

    Route::delete('/user/{id}', [UserController::class, 'destroy'])
        ->name('user.destroy');

});


// ==============================
// SERVICES / JASA
// ==============================

Route::get('/services', [ServiceController::class, 'index'])
    ->name('services.index');

Route::get('/services/create', [ServiceController::class, 'create'])
    ->name('services.create');

Route::post('/services', [ServiceController::class, 'store'])
    ->name('services.store');

Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])
    ->name('services.edit');

Route::get('/services/{service}', [ServiceController::class, 'show'])
    ->name('services.show');

Route::put('/services/{service}', [ServiceController::class, 'update'])
    ->name('services.update');

Route::delete('/services/{service}', [ServiceController::class, 'destroy'])
    ->name('services.destroy');


// ==============================
// ORDERS / PESANAN
// ==============================

// Orders - dapat diakses admin, customer, dan designer
Route::middleware(['auth', 'role:admin,customer,designer'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});

// Orders - admin dan customer
Route::middleware(['auth', 'role:admin,customer'])->group(function () {
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
});

// Orders - khusus admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
});

// Detail pesanan - harus diletakkan setelah route create
Route::middleware(['auth', 'role:admin,customer,designer'])->group(function () {
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// Orders - khusus designer untuk mengubah status
Route::middleware(['auth', 'role:designer'])->group(function () {
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])
        ->name('orders.updateStatus');
});


// ==============================
// PROJECT
// ==============================

Route::get('/projects', [ProjectController::class, 'index'])
    ->name('projects.index');

Route::get('/projects/create', [ProjectController::class, 'create'])
    ->name('projects.create');

Route::post('/projects', [ProjectController::class, 'store'])
    ->name('projects.store');

Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])
    ->name('projects.edit');

Route::get('/projects/{project}', [ProjectController::class, 'show'])
    ->name('projects.show');

Route::put('/projects/{project}', [ProjectController::class, 'update'])
    ->name('projects.update');

Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])
    ->name('projects.destroy');