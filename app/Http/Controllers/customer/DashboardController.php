<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Pastikan hanya customer yang dapat mengakses dashboard ini
        if (!$user || $user->role !== 'customer') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Mengambil pesanan milik customer yang sedang login
        $orders = Order::with(['service', 'designer', 'project'])
            ->where('customer_id', $user->id)
            ->latest()
            ->get();

        // Menghitung jumlah pesanan berdasarkan status
        $totalOrders = $orders->count();

        $pendingOrders = $orders->where('status', 'menunggu')->count();

        $processingOrders = $orders->where('status', 'diproses')->count();

        $completedOrders = $orders->where('status', 'selesai')->count();

        $cancelledOrders = $orders->where('status', 'dibatalkan')->count();

        // Mengambil 5 pesanan terbaru
        $latestOrders = $orders->take(5);

        return view('customer.dashboard', compact(
            'user',
            'orders',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'cancelledOrders',
            'latestOrders'
        ));
    }
}