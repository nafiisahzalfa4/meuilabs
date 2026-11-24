<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Order;

class OrderController extends Controller
{
    private function checkDesigner()
    {
        if (!Auth::check() || Auth::user()->role !== 'designer') {
            abort(403, 'Anda tidak memiliki akses.');
        }
    }

    private function findDesignerOrder($id)
    {
        return Order::with(['customer', 'service', 'project'])
            ->where('designer_id', Auth::id())
            ->findOrFail($id);
    }

    public function index()
    {
        $this->checkDesigner();

        $orders = Order::with(['customer', 'service', 'project'])
            ->where('designer_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('designer.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $this->checkDesigner();

        $order = $this->findDesignerOrder($id);

        return view('designer.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $this->checkDesigner();

        $order = $this->findDesignerOrder($id);

        $validated = $request->validate([
            'status' => 'required|in:diproses,selesai',
        ]);

        if (in_array($order->status, ['selesai', 'dibatalkan'])) {
            return back()->with('error', 'Status pekerjaan tidak dapat diubah.');
        }

        $order->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Status pekerjaan berhasil diperbarui!');
    }

    public function update(Request $request, $id)
    {
        return $this->updateStatus($request, $id);
    }
}