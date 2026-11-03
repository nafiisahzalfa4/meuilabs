<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use App\Service;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan semua pesanan.
     */
    public function index()
    {
        $user = auth()->user();

        $query = Order::with('customer', 'designer', 'service', 'project')
            ->latest();

        // Admin dapat melihat semua pesanan
        if ($user->role == 'admin') {
            // Tidak perlu filter
        }

        // Customer hanya melihat pesanan miliknya
        elseif ($user->role == 'customer') {
            $query->where('customer_id', $user->id);
        }

        // Designer hanya melihat pesanan yang ditugaskan kepadanya
        elseif ($user->role == 'designer') {
            $query->where('designer_id', $user->id);
        }

        else {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $orders = $query->get();

        return view('orders.index', compact('orders'));
    }

        /**
         * Menampilkan form tambah pesanan.
         */
        public function create()
        {
            $customers = User::where('role', 'customer')
                ->orderBy('name')
                ->get();

            $designers = User::where('role', 'designer')
                ->orderBy('name')
                ->get();

            $services = Service::where('status', 'aktif')
                ->orderBy('nama_jasa')
                ->get();

            return view('orders.create', compact(
                'customers',
                'designers',
                'services'
            ));
        }

    /**
     * Menyimpan pesanan baru.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        // Validasi berdasarkan role
        if ($user->role == 'admin') {
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

            $totalHarga = $request->total_harga;
            $status = $request->status;
            $customerId = $customer->id;
            $designerId = $designer ? $designer->id : null;
        }

        elseif ($user->role == 'customer') {
            $request->validate([
                'service_id' => 'required|exists:services,id',
                'tanggal_pesan' => 'required|date',
                'catatan' => 'nullable|string',
            ]);

            $customerId = $user->id;
            $designerId = null;
            $totalHarga = null;
            $status = 'menunggu';
        }

        else {
            abort(403, 'Anda tidak memiliki akses.');
        }

        // Pastikan jasa masih aktif
        $service = Service::where('status', 'aktif')
            ->findOrFail($request->service_id);

        // Customer menggunakan harga jasa dari database
        if ($user->role == 'customer') {
            $totalHarga = $service->harga;
        }

        // Simpan pesanan
        Order::create([
            'customer_id' => $customerId,
            'designer_id' => $designerId,
            'service_id' => $service->id,
            'tanggal_pesan' => $request->tanggal_pesan,
            'catatan' => $request->catatan,
            'total_harga' => $totalHarga,
            'status' => $status,
        ]);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Pesanan berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail pesanan.
     */
    public function show(Order $order)
    {
        $user = auth()->user();

        // Customer hanya boleh melihat pesanan miliknya
        if ($user->role == 'customer' && $order->customer_id != $user->id) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        // Designer hanya boleh melihat pesanan yang ditugaskan kepadanya
        if ($user->role == 'designer' && $order->designer_id != $user->id) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        if (!in_array($user->role, ['admin', 'customer', 'designer'])) {
            abort(403);
        }

        $order->load('customer', 'designer', 'service', 'project');

        return view('orders.show', compact('order'));
    }

    /**
     * Menampilkan form edit pesanan.
     */
    public function edit(Order $order)
    {
        $customers = User::where('role', 'customer')
            ->orderBy('name')
            ->get();

        $designers = User::where('role', 'designer')
            ->orderBy('name')
            ->get();

        $services = Service::where('status', 'aktif')
            ->orderBy('nama_jasa')
            ->get();

        return view('orders.edit', compact(
            'order',
            'customers',
            'designers',
            'services'
        ));
    }

    /**
     * Mengupdate pesanan.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'designer_id' => 'nullable|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'tanggal_pesan' => 'required|date',
            'catatan' => 'nullable|string',
            'total_harga' => 'required|numeric|min:0',
            'status' => 'required|in:menunggu,diproses,selesai,dibatalkan',
        ]);

        $customer = User::findOrFail($request->customer_id);

        if ($customer->role !== 'customer') {
            return back()
                ->withInput()
                ->withErrors([
                    'customer_id' => 'User yang dipilih bukan customer.'
                ]);
        }

        if ($request->designer_id) {

            $designer = User::findOrFail($request->designer_id);

            if ($designer->role !== 'designer') {
                return back()
                    ->withInput()
                    ->withErrors([
                        'designer_id' => 'User yang dipilih bukan designer.'
                    ]);
            }
        }

        $service = Service::findOrFail($request->service_id);

        if ($service->status !== 'aktif') {
            return back()
                ->withInput()
                ->withErrors([
                    'service_id' => 'Jasa yang dipilih sedang tidak aktif.'
                ]);
        }

        $order->update([
            'customer_id' => $request->customer_id,
            'designer_id' => $request->designer_id,
            'service_id' => $request->service_id,
            'tanggal_pesan' => $request->tanggal_pesan,
            'catatan' => $request->catatan,
            'total_harga' => $request->total_harga,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Pesanan berhasil diperbarui.');
    }

    /**
     * Menghapus pesanan.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $user = auth()->user();

        // Pastikan hanya designer yang ditugaskan
        // yang dapat mengubah status pesanan
        if ($user->role != 'designer' || $order->designer_id != $user->id) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $request->validate([
            'status' => 'required|in:diproses,selesai',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()
            ->route('orders.show', $order->id)
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }
}