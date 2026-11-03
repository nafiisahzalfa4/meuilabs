<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Portofolio;

class PortofolioController extends Controller
{
    // Menampilkan semua portofolio
    public function index()
    {
        $portofolios = Portofolio::with('designer')->latest()->get();

        return view('portofolios.index', compact('portofolios'));
    }

    // Menampilkan form tambah portofolio
    public function create()
    {
        return view('portofolios.create');
    }

    // Menyimpan portofolio baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'kategori' => 'required|in:website,mobile,dashboard,lainnya',
        ]);

        $gambar = null;

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')
                ->store('portfolios', 'public');
        }

        Portofolio::create([
            'designer_id' => Auth::id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar,
            'kategori' => $request->kategori,
        ]);

        return redirect()->route('portfolios.index')
            ->with('success', 'Portofolio berhasil ditambahkan!');
    }

    // Menampilkan detail portofolio
    public function show($portfolio)
    {
        $portfolio = Portofolio::with('designer')->findOrFail($portfolio);

        return view('portofolios.show', compact('portfolio'));
    }

    // Menampilkan form edit portofolio
    public function edit($portfolio)
    {
        $portfolio = Portofolio::findOrFail($portfolio);

        return view('portofolios.edit', compact('portfolio'));
    }

    // Memperbarui portofolio
    public function update(Request $request, $portfolio)
    {
        $portfolio = Portofolio::findOrFail($portfolio);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'kategori' => 'required|in:website,mobile,dashboard,lainnya',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')
                ->store('portfolios', 'public');
        }

        $portfolio->update($data);

        return redirect()->route('portfolios.index')
            ->with('success', 'Portofolio berhasil diperbarui!');
    }

    // Menghapus portofolio
    public function destroy($portfolio)
    {
        $portfolio = Portofolio::findOrFail($portfolio);

        $portfolio->delete();

        return redirect()->route('portfolios.index')
            ->with('success', 'Portofolio berhasil dihapus!');
    }
}