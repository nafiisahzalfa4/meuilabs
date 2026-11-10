<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Order;

class OrderController extends Controller
{
    /**
     * Memastikan pengguna adalah designer.
     */
    private function checkDesigner()
    {
        if (!Auth::check() || Auth::user()->role !== 'designer') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
    }

    /**
     * Mengambil pesanan yang ditugaskan kepada designer yang login.
     */
    private function findDesignerOrder($id)
    {
        return Order::with(['customer', 'service', 'project'])
            ->where('designer_id', Auth::id())
            ->findOrFail($id);
    }

    /**
     * Menampilkan daftar pekerjaan designer.
     */
    public function index()
    {
        $this->checkDesigner();

        $orders = Order::with(['customer', 'service', 'project'])
            ->where('designer_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail pekerjaan.
     */
    public function show($id)
    {
        $this->checkDesigner();

        $order = $this->findDesignerOrder($id);

        return view('orders.show', compact('order'));
    }

    /**
     * Memperbarui status pekerjaan.
     */
    public function updateStatus(Request $request, $id)
    {
        $this->checkDesigner();

        $order = $this->findDesignerOrder($id);

        // Status yang boleh dipilih oleh designer
        $validated = $request->validate([
            'status' => 'required|in:diproses,selesai',
        ]);

        // Pesanan yang sudah selesai atau dibatalkan tidak dapat diubah lagi
        if (in_array($order->status, ['selesai', 'dibatalkan'])) {
            return redirect()
                ->back()
                ->with('error', 'Status pekerjaan ini sudah tidak dapat diubah.');
        }

        $order->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->back()
            ->with('success', 'Status pekerjaan berhasil diperbarui!');
    }

    /**
     * Alternatif method untuk route update.
     */
    public function update(Request $request, $id)
    {
        return $this->updateStatus($request, $id);
    }
}