<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use App\Service;
use App\Portofolio;
use App\Project;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik pengguna
        $totalUsers = User::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalDesigners = User::where('role', 'designer')->count();

        // Statistik pesanan
        $totalOrders = Order::count();

        $pendingOrders = Order::where('status', 'menunggu')->count();
        $processingOrders = Order::where('status', 'diproses')->count();
        $completedOrders = Order::where('status', 'selesai')->count();
        $cancelledOrders = Order::where('status', 'dibatalkan')->count();

        // Statistik layanan, portofolio, dan proyek
        $totalServices = Service::count();
        $totalPortfolios = Portofolio::count();
        $totalProjects = Project::count();

        // Lima pesanan terbaru
        $latestOrders = Order::with(
            'customer',
            'designer',
            'service'
        )->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalCustomers',
            'totalDesigners',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'cancelledOrders',
            'totalServices',
            'totalPortfolios',
            'totalProjects',
            'latestOrders'
        ));
    }
}