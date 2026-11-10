<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// Controller lama untuk halaman publik
use App\Http\Controllers\Admin\PortofolioController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\LoginController;

// Controller Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\PortofolioController as AdminPortofolioController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;

// Controller Customer
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;

// Controller Designer
use App\Http\Controllers\Designer\DashboardController as DesignerDashboardController;
use App\Http\Controllers\Designer\OrderController as DesignerOrderController;


/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    $services = DB::table('services')
        ->where('status', 'aktif')
        ->latest('id')
        ->take(6)
        ->get();

    $portfolios = DB::table('portfolios')
        ->latest('id')
        ->take(6)
        ->get();

    return view('welcome', compact('services', 'portfolios'));

})->name('home');


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.post');

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| PUBLIC SERVICES
|--------------------------------------------------------------------------
*/

// Halaman layanan yang bisa dilihat pengunjung
Route::get('/services', [ServiceController::class, 'index'])
    ->name('services.index');

// Route detail diletakkan setelah route create admin
Route::get('/services/{service}', [ServiceController::class, 'show'])
    ->name('services.show');


/*
|--------------------------------------------------------------------------
| PUBLIC PORTFOLIOS
|--------------------------------------------------------------------------
*/

// Halaman portfolio yang bisa dilihat pengunjung
Route::get('/portfolios', [PortofolioController::class, 'index'])
    ->name('portfolios.index');

Route::get('/portfolios/{portfolio}', [PortofolioController::class, 'show'])
    ->name('portfolios.show');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');


        /*
        | USER MANAGEMENT
        */

        Route::get('/user', [AdminUserController::class, 'index'])
            ->name('user.index');

        Route::get('/user/create', [AdminUserController::class, 'create'])
            ->name('user.create');

        Route::post('/user', [AdminUserController::class, 'store'])
            ->name('user.store');

        Route::get('/user/{id}/edit', [AdminUserController::class, 'edit'])
            ->name('user.edit');

        Route::put('/user/{id}', [AdminUserController::class, 'update'])
            ->name('user.update');

        Route::delete('/user/{id}', [AdminUserController::class, 'destroy'])
            ->name('user.destroy');


        /*
        | SERVICE MANAGEMENT
        */

        Route::get('/services', [AdminServiceController::class, 'index'])
            ->name('services.index');

        Route::get('/services/create', [AdminServiceController::class, 'create'])
            ->name('services.create');

        Route::post('/services', [AdminServiceController::class, 'store'])
            ->name('services.store');

        Route::get('/services/{service}/edit', [AdminServiceController::class, 'edit'])
            ->name('services.edit');

        Route::put('/services/{service}', [AdminServiceController::class, 'update'])
            ->name('services.update');

        Route::delete('/services/{service}', [AdminServiceController::class, 'destroy'])
            ->name('services.destroy');


        /*
        | PORTFOLIO MANAGEMENT
        */

        Route::get('/portfolios', [AdminPortofolioController::class, 'index'])
            ->name('portfolios.index');

        Route::get('/portfolios/create', [AdminPortofolioController::class, 'create'])
            ->name('portfolios.create');

        Route::post('/portfolios', [AdminPortofolioController::class, 'store'])
            ->name('portfolios.store');

        // DETAIL PORTOFOLIO
        Route::get('/portfolios/{portfolio}', [AdminPortofolioController::class, 'show'])
            ->name('portfolios.show');

        Route::get('/portfolios/{portfolio}/edit', [AdminPortofolioController::class, 'edit'])
            ->name('portfolios.edit');

        Route::put('/portfolios/{portfolio}', [AdminPortofolioController::class, 'update'])
            ->name('portfolios.update');

        Route::delete('/portfolios/{portfolio}', [AdminPortofolioController::class, 'destroy'])
            ->name('portfolios.destroy');


        /*
        | ADMIN ORDER MANAGEMENT
        */

        Route::get('/orders', [AdminOrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/create', [AdminOrderController::class, 'create'])
            ->name('orders.create');

        Route::post('/orders', [AdminOrderController::class, 'store'])
            ->name('orders.store');

        Route::get('/orders/{order}/edit', [AdminOrderController::class, 'edit'])
            ->name('orders.edit');

        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
            ->name('orders.show');

        Route::put('/orders/{order}', [AdminOrderController::class, 'update'])
            ->name('orders.update');

        Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])
            ->name('orders.destroy');


        /*
        | PROJECT MANAGEMENT
        */

        Route::get('/projects', [AdminProjectController::class, 'index'])
            ->name('projects.index');

        Route::get('/projects/create', [AdminProjectController::class, 'create'])
            ->name('projects.create');

        Route::post('/projects', [AdminProjectController::class, 'store'])
            ->name('projects.store');

        Route::get('/projects/{project}/edit', [AdminProjectController::class, 'edit'])
            ->name('projects.edit');

        Route::get('/projects/{project}', [AdminProjectController::class, 'show'])
            ->name('projects.show');

        Route::put('/projects/{project}', [AdminProjectController::class, 'update'])
            ->name('projects.update');

        Route::delete('/projects/{project}', [AdminProjectController::class, 'destroy'])
            ->name('projects.destroy');

    });


/*
|--------------------------------------------------------------------------
| CUSTOMER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        // Dashboard Customer
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])
            ->name('dashboard');


        // Pesanan Customer
        Route::get('/orders', [CustomerOrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/create', [CustomerOrderController::class, 'create'])
            ->name('orders.create');

        Route::post('/orders', [CustomerOrderController::class, 'store'])
            ->name('orders.store');

        Route::get('/orders/{order}/edit', [CustomerOrderController::class, 'edit'])
            ->name('orders.edit');

        Route::get('/orders/{order}', [CustomerOrderController::class, 'show'])
            ->name('orders.show');

        Route::put('/orders/{order}', [CustomerOrderController::class, 'update'])
            ->name('orders.update');

        Route::delete('/orders/{order}', [CustomerOrderController::class, 'destroy'])
            ->name('orders.destroy');

    });


/*
|--------------------------------------------------------------------------
| DESIGNER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:designer'])
    ->prefix('designer')
    ->name('designer.')
    ->group(function () {

        // Dashboard Designer
        Route::get('/dashboard', [DesignerDashboardController::class, 'index'])
            ->name('dashboard');


        // Pekerjaan Designer
        Route::get('/orders', [DesignerOrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/{order}', [DesignerOrderController::class, 'show'])
            ->name('orders.show');

        Route::patch('/orders/{order}/status', [DesignerOrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');

    });