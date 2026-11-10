<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use App\Service;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private function checkAdmin()
    {
        abort_unless(auth()->check() && auth()->user()->role == 'admin', 403);
    }

    // Menampilkan semua pesanan
    
    public function index(Request $request)
    {
        $query = Order::with([
            'customer',
            'designer',
            'service'
        ]);

        // Pencarian pesanan
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('customer', function ($customer) use ($search) {
                    $customer->where('name', 'like', "%{$search}%")
                            ->orWhere('nama', 'like', "%{$search}%");
                })
                ->orWhereHas('service', function ($service) use ($search) {
                    $service->where('nama_jasa', 'like', "%{$search}%")
                            ->orWhere('nama', 'like', "%{$search}%");
                });
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pagination
        $orders = $query->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }


    // Form tambah pesanan
    public function create()
    {
        $this->checkAdmin();

        $customers = User::where('role', 'customer')
            ->orderBy('name')
            ->get();

        $designers = User::where('role', 'designer')
            ->orderBy('name')
            ->get();

        $services = Service::where('status', 'aktif')
            ->orderBy('nama_jasa')
            ->get();

        return view('admin.orders.create', compact(
            'customers',
            'designers',
            'services'
        ));
    }

    // Menyimpan pesanan
    public function store(Request $request)
    {
        $this->checkAdmin();

        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'designer_id' => 'nullable|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'tanggal_pesan' => 'required|date',
            'catatan' => 'nullable|string',
            'total_harga' => 'required|numeric|min:0',
            'status' => 'required|in:menunggu,diproses,selesai,dibatalkan',
        ]);

        $customer = User::where('role', 'customer')
            ->findOrFail($request->customer_id);

        $designer = null;

        if ($request->designer_id) {
            $designer = User::where('role', 'designer')
                ->findOrFail($request->designer_id);
        }

        $service = Service::where('status', 'aktif')
            ->findOrFail($request->service_id);

        Order::create([
            'customer_id' => $customer->id,
            'designer_id' => $designer ? $designer->id : null,
            'service_id' => $service->id,
            'tanggal_pesan' => $request->tanggal_pesan,
            'catatan' => $request->catatan,
            'total_harga' => $request->total_harga,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Pesanan berhasil ditambahkan.');
    }

    // Detail pesanan
    public function show(Order $order)
    {
        $this->checkAdmin();

        $order->load('customer', 'designer', 'service', 'project');

        return view('admin.orders.show', compact('order'));
    }

    // Form edit pesanan
    public function edit(Order $order)
    {
        $this->checkAdmin();

        $customers = User::where('role', 'customer')
            ->orderBy('name')
            ->get();

        $designers = User::where('role', 'designer')
            ->orderBy('name')
            ->get();

        $services = Service::where('status', 'aktif')
            ->orderBy('nama_jasa')
            ->get();

        return view('admin.orders.edit', compact(
            'order',
            'customers',
            'designers',
            'services'
        ));
    }

    // Update pesanan
    public function update(Request $request, Order $order)
    {
        $this->checkAdmin();

        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'designer_id' => 'nullable|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'tanggal_pesan' => 'required|date',
            'catatan' => 'nullable|string',
            'total_harga' => 'required|numeric|min:0',
            'status' => 'required|in:menunggu,diproses,selesai,dibatalkan',
        ]);

        $customer = User::where('role', 'customer')
            ->findOrFail($request->customer_id);

        $designer = null;

        if ($request->designer_id) {
            $designer = User::where('role', 'designer')
                ->findOrFail($request->designer_id);
        }

        $service = Service::where('status', 'aktif')
            ->findOrFail($request->service_id);

        $order->update([
            'customer_id' => $customer->id,
            'designer_id' => $designer ? $designer->id : null,
            'service_id' => $service->id,
            'tanggal_pesan' => $request->tanggal_pesan,
            'catatan' => $request->catatan,
            'total_harga' => $request->total_harga,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Pesanan berhasil diperbarui.');
    }

    // Hapus pesanan
    public function destroy(Order $order)
    {
        $this->checkAdmin();

        $order->delete();

        return redirect()
            ->route('orders.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }
}