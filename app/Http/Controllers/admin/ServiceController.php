<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{
    private function checkAdmin()
    {
        abort_unless(auth()->check() && auth()->user()->role == 'admin', 403);
    }

    // Menampilkan semua jasa
    public function index()
    {
        $this->checkAdmin();

        $services = Service::latest()->get();

        return view('admin.services.index', compact('services'));
    }

    // Form tambah jasa
    public function create()
    {
        $this->checkAdmin();

        return view('admin.services.create');
    }

    // Menyimpan jasa
    public function store(Request $request)
    {
        $this->checkAdmin();

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
            ->with('success', 'Jasa berhasil ditambahkan.');
    }

    // Detail jasa
    public function show($id)
    {
        $this->checkAdmin();

        $service = Service::findOrFail($id);

        return view('admin.services.show', compact('service'));
    }

    // Form edit jasa
    public function edit($id)
    {
        $this->checkAdmin();

        $service = Service::findOrFail($id);

        return view('services.edit', compact('service'));
    }

    // Update jasa
    public function update(Request $request, $id)
    {
        $this->checkAdmin();

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
            ->with('success', 'Jasa berhasil diperbarui.');
    }

    // Hapus jasa
    public function destroy($id)
    {
        $this->checkAdmin();

        $service = Service::findOrFail($id);

        if ($service->gambar) {
            $gambar = public_path('images/services/' . $service->gambar);

            if (File::exists($gambar)) {
                File::delete($gambar);
            }
        }

        $service->delete();

        return redirect()
            ->route('services.index')
            ->with('success', 'Jasa berhasil dihapus.');
    }
}