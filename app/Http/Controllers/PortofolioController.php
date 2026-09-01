<?php

namespace App\Http\Controllers;

use App\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortofolioController extends Controller
{
    /**
     * Menampilkan semua portfolio.
     */
    public function index()
    {
        $portofolios = Portofolio::with('designer')
            ->latest()
            ->get();

        return view('portfolios.index', compact('portofolios'));
    }

    /**
     * Menampilkan form tambah portfolio.
     */
    public function create()
    {
        return view('portfolios.create');
    }

    /**
     * Menyimpan portfolio baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'kategori' => 'required|in:website,mobile,dashboard,lainnya',
        ]);

        $gambar = null;

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('portfolios', 'public');
        }

        Portofolio::create([
            'designer_id' => Auth::id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar,
            'kategori' => $request->kategori,
        ]);

        return redirect()
            ->route('portfolios.index')
            ->with('success', 'Portfolio berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail portfolio.
     */
    public function show(Portofolio $portfolio)
    {
        $portfolio->load('designer');

        return view('portfolios.show', compact('portfolio'));
    }

    /**
     * Menampilkan form edit portfolio.
     */
    public function edit(Portofolio $portfolio)
    {
        return view('portfolios.edit', compact('portfolio'));
    }

    /**
     * Mengupdate portfolio.
     */
    public function update(Request $request, Portofolio $portfolio)
    {
        $request->validate([
            'judul' => 'required|string|max:100',
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

        return redirect()
            ->route('portfolios.index')
            ->with('success', 'Portfolio berhasil diperbarui.');
    }

    /**
     * Menghapus portfolio.
     */
    public function destroy(Portofolio $portfolio)
    {
        $portfolio->delete();

        return redirect()
            ->route('portfolios.index')
            ->with('success', 'Portfolio berhasil dihapus.');
    }
}