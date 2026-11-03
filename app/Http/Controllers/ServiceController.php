<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{
    // Menampilkan semua layanan
    public function index()
    {
        $services = Service::latest()->get();

        return view('services.index', compact('services'));
    }

    // Menampilkan form tambah layanan
    public function create()
    {
        return view('services.create');
    }

    // Menyimpan layanan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_jasa' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $data = $request->only([
            'nama_jasa',
            'deskripsi',
            'harga',
            'status',
        ]);

        if ($request->hasFile('gambar')) {
            $folder = public_path('images/services');

            if (!File::exists($folder)) {
                File::makeDirectory($folder, 0755, true);
            }

            $gambar = $request->file('gambar');

            $namaGambar = time() . '_' . uniqid() . '.' .
                $gambar->getClientOriginalExtension();

            $gambar->move($folder, $namaGambar);

            $data['gambar'] = $namaGambar;
        }

        Service::create($data);

        return redirect()
            ->route('services.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    // Menampilkan detail layanan
    public function show($id)
    {
        $service = Service::findOrFail($id);

        return view('services.show', compact('service'));
    }

    // Menampilkan form edit layanan
    public function edit($id)
    {
        $service = Service::findOrFail($id);

        return view('services.edit', compact('service'));
    }

    // Memperbarui layanan
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'nama_jasa' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $data = $request->only([
            'nama_jasa',
            'deskripsi',
            'harga',
            'status',
        ]);

        if ($request->hasFile('gambar')) {
            $folder = public_path('images/services');

            if (!File::exists($folder)) {
                File::makeDirectory($folder, 0755, true);
            }

            // Hapus gambar lama
            if ($service->gambar) {
                $gambarLama = $folder . '/' . $service->gambar;

                if (File::exists($gambarLama)) {
                    File::delete($gambarLama);
                }
            }

            $gambar = $request->file('gambar');

            $namaGambar = time() . '_' . uniqid() . '.' .
                $gambar->getClientOriginalExtension();

            $gambar->move($folder, $namaGambar);

            $data['gambar'] = $namaGambar;
        }

        $service->update($data);

        return redirect()
            ->route('services.index')
            ->with('success', 'Data layanan berhasil diperbarui.');
    }

    // Menghapus layanan
    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        // Hapus file gambar
        if ($service->gambar) {
            $gambar = public_path(
                'images/services/' . $service->gambar
            );

            if (File::exists($gambar)) {
                File::delete($gambar);
            }
        }

        $service->delete();

        return redirect()
            ->route('services.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}