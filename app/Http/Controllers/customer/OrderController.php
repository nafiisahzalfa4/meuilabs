<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Order;
use App\Service;

class OrderController extends Controller
{
    /**
     * Memastikan pengguna adalah customer.
     */
    private function checkCustomer()
    {
        if (!Auth::check() || Auth::user()->role !== 'customer') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
    }

    /**
     * Mengambil pesanan milik customer yang sedang login.
     */
    private function findCustomerOrder($id)
    {
        return Order::with(['customer', 'designer', 'service', 'project'])
            ->where('customer_id', Auth::id())
            ->findOrFail($id);
    }

    /**
     * Menampilkan daftar pesanan.
     */
    public function index()
    {
        $this->checkCustomer();

        $orders = Order::with(['service', 'designer', 'project'])
            ->where('customer_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Form tambah pesanan.
     */
    public function create()
    {
        $this->checkCustomer();

        $services = Service::where('status', 'aktif')
            ->orderBy('nama_jasa')
            ->get();

        return view('customer.orders.create', compact('services'));
    }

    /**
     * Menyimpan pesanan.
     */
    public function store(Request $request)
    {
        $this->checkCustomer();

        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'tanggal_pesan' => 'required|date|after_or_equal:today',
            'catatan' => 'nullable|string|max:2000',
        ]);

        $service = Service::where('id', $validated['service_id'])
            ->where('status', 'aktif')
            ->first();

        if (!$service) {
            return back()
                ->withInput()
                ->withErrors([
                    'service_id' => 'Layanan yang dipilih tidak tersedia.'
                ]);
        }

        Order::create([
            'customer_id' => Auth::id(),
            'designer_id' => null,
            'service_id' => $service->id,
            'tanggal_pesan' => $validated['tanggal_pesan'],
            'catatan' => $validated['catatan'] ?? null,
            'total_harga' => $service->harga,
            'status' => 'menunggu',
        ]);

        return redirect()
            ->route('customer.orders.index')
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    /**
     * Detail pesanan.
     */
    public function show($id)
    {
        $this->checkCustomer();

        $order = $this->findCustomerOrder($id);

        return view('orders.show', compact('order'));
    }

    /**
     * Form edit pesanan.
     */
    public function edit($id)
    {
        $this->checkCustomer();

        $order = $this->findCustomerOrder($id);

        if ($order->status !== 'menunggu') {
            return redirect()
                ->route('customer.orders.index')
                ->with('error', 'Pesanan tidak dapat diedit karena sudah diproses.');
        }

        $services = Service::where('status', 'aktif')
            ->orderBy('nama_jasa')
            ->get();

        return view('customer.orders.edit', compact('order', 'services'));
    }

    /**
     * Memperbarui pesanan.
     */
    public function update(Request $request, $id)
    {
        $this->checkCustomer();

        $order = $this->findCustomerOrder($id);

        if ($order->status !== 'menunggu') {
            return redirect()
                ->route('customer.orders.index')
                ->with('error', 'Pesanan tidak dapat diubah karena sudah diproses.');
        }

        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'tanggal_pesan' => 'required|date|after_or_equal:today',
            'catatan' => 'nullable|string|max:2000',
        ]);

        $service = Service::where('id', $validated['service_id'])
            ->where('status', 'aktif')
            ->first();

        if (!$service) {
            return back()
                ->withInput()
                ->withErrors([
                    'service_id' => 'Layanan yang dipilih tidak tersedia.'
                ]);
        }

        $order->update([
            'service_id' => $service->id,
            'tanggal_pesan' => $validated['tanggal_pesan'],
            'catatan' => $validated['catatan'] ?? null,
            'total_harga' => $service->harga,
        ]);

        return redirect()
            ->route('customer.orders.index')
            ->with('success', 'Pesanan berhasil diperbarui!');
    }

    /**
     * Membatalkan pesanan.
     */
    public function destroy($id)
    {
        $this->checkCustomer();

        $order = $this->findCustomerOrder($id);

        if ($order->status !== 'menunggu') {
            return redirect()
                ->route('customer.orders.index')
                ->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        $order->update([
            'status' => 'dibatalkan',
        ]);

        return redirect()
            ->route('customer.orders.index')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }
}