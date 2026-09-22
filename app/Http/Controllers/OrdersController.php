<?php

namespace App\Http\Controllers;

use App\Orders;
use App\Service;
use App\User;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Menampilkan semua order sesuai role user.
     */
    public function index()
    {
        $user = auth()->user();

        // Admin melihat semua order
        if ($user->role === 'admin') {

            $orders = Orders::with([
                'customer',
                'designer',
                'service'
            ])
            ->latest()
            ->get();

        }

        // Customer hanya melihat order miliknya
        elseif ($user->role === 'customer') {

            $orders = Orders::with([
                'customer',
                'designer',
                'service'
            ])
            ->where('customer_id', $user->id)
            ->latest()
            ->get();

        }

        // Designer hanya melihat order yang ditugaskan
        elseif ($user->role === 'designer') {

            $orders = Orders::with([
                'customer',
                'designer',
                'service'
            ])
            ->where('designer_id', $user->id)
            ->latest()
            ->get();

        }

        else {
            abort(403);
        }

        return view('orders.index', compact('orders'));
    }


    /**
     * Menampilkan form untuk membuat order.
     */
    public function create()
    {
        // Hanya customer
        if (auth()->user()->role !== 'customer') {
            abort(403);
        }

        // Ambil service yang aktif
        $services = Service::where('status', 'aktif')
            ->orderBy('nama_jasa')
            ->get();

        return view('orders.create', compact('services'));
    }


    /**
     * Menyimpan order baru.
     */
    public function store(Request $request)
    {
        // Hanya customer
        if (auth()->user()->role !== 'customer') {
            abort(403);
        }

        // Validasi
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'tanggal_pesan' => 'required|date',
            'catatan' => 'nullable|string|max:1000',
        ]);

        // Ambil service
        $service = Service::where('id', $validated['service_id'])
            ->where('status', 'aktif')
            ->firstOrFail();

        // Simpan order
        Orders::create([
            'customer_id' => auth()->id(),
            'designer_id' => null,
            'service_id' => $service->id,
            'tanggal_pesan' => $validated['tanggal_pesan'],
            'catatan' => $validated['catatan'] ?? null,
            'total_harga' => $service->harga,
            'status' => 'menunggu',
        ]);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Pesanan berhasil dibuat.');
    }


    /**
     * Menampilkan detail order.
     */
    public function show(Orders $order)
    {
        $user = auth()->user();

        // Customer hanya boleh melihat order sendiri
        if (
            $user->role === 'customer' &&
            $order->customer_id != $user->id
        ) {
            abort(403);
        }

        // Designer hanya boleh melihat order yang ditugaskan
        if (
            $user->role === 'designer' &&
            $order->designer_id != $user->id
        ) {
            abort(403);
        }

        // Load relationship
        $order->load([
            'customer',
            'designer',
            'service',
            'project'
        ]);

        return view('orders.show', compact('order'));
    }


    /**
     * Menampilkan form edit order.
     */
    public function edit(Orders $order)
    {
        // Hanya admin
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        // Ambil semua designer
        $designers = User::where('role', 'designer')
            ->orderBy('name')
            ->get();

        // Ambil service aktif
        $services = Service::where('status', 'aktif')
            ->orderBy('nama_jasa')
            ->get();

        return view('orders.edit', compact(
            'order',
            'designers',
            'services'
        ));
    }


    /**
     * Mengupdate order.
     */
    public function update(Request $request, Orders $order)
    {
        // Hanya admin
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        // Validasi
        $validated = $request->validate([
            'designer_id' => 'nullable|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'status' => 'required|in:menunggu,diproses,selesai,dibatalkan',
        ]);

        // Pastikan designer memang role designer
        if ($validated['designer_id']) {

            $designer = User::where('id', $validated['designer_id'])
                ->where('role', 'designer')
                ->first();

            if (!$designer) {
                return back()
                    ->withErrors([
                        'designer_id' => 'User yang dipilih bukan designer.'
                    ])
                    ->withInput();
            }
        }

        // Ambil service
        $service = Service::findOrFail($validated['service_id']);

        // Update order
        $order->update([
            'designer_id' => $validated['designer_id'],
            'service_id' => $validated['service_id'],
            'total_harga' => $service->harga,
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Order berhasil diperbarui.');
    }


    /**
     * Menghapus order.
     */
    public function destroy(Orders $order)
    {
        // Hanya admin
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $order->delete();

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order berhasil dihapus.');
    }
}