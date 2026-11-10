<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Pastikan hanya designer yang dapat mengakses dashboard
        if (!$user || $user->role !== 'designer') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Mengambil pesanan yang ditugaskan kepada designer yang login
        $orders = Order::with(['customer', 'service', 'project'])
            ->where('designer_id', $user->id)
            ->latest()
            ->get();

        // Menghitung jumlah pekerjaan
        $totalOrders = $orders->count();

        $pendingOrders = $orders->where('status', 'menunggu')->count();

        $processingOrders = $orders->where('status', 'diproses')->count();

        $completedOrders = $orders->where('status', 'selesai')->count();

        $cancelledOrders = $orders->where('status', 'dibatalkan')->count();

        // Mengambil 5 pekerjaan terbaru
        $latestOrders = $orders->take(5);

        return view('designer.dashboard', compact(
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