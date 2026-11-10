<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Portofolio;

class PortofolioController extends Controller
{
    private function checkAdmin()
    {
        abort_unless(auth()->check() && auth()->user()->role == 'admin', 403);
    }

    // Menampilkan semua portofolio
    
    public function index(Request $request)
    {
        $query = \App\Portofolio::with('designer');

        // Pencarian portofolio
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        // Pagination
        $portfolios = $query->latest()->paginate(10);

        return view('admin.portofolios.index', compact('portfolios'));
    }


    // Form tambah portofolio
    public function create()
    {
        $designers = User::where('role', 'designer')->get();

        return view('admin.portofolios.create', compact('designers'));
    }

    // Menyimpan portofolio
    public function store(Request $request)
    {
        $this->checkAdmin();

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
            // Mengikuti struktur lama project.
            // Jika Admin harus memilih Designer, nanti perlu ditambahkan
            // field designer_id pada form.
            'designer_id' => Auth::id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar,
            'kategori' => $request->kategori,
        ]);

        return redirect()
            ->route('portfolios.index')
            ->with('success', 'Portofolio berhasil ditambahkan.');
    }

    // Detail portofolio
    public function show($portfolio)
    {
        $this->checkAdmin();

        $portfolio = Portofolio::with('designer')
            ->findOrFail($portfolio);

        return view('admin.portofolios.show', compact('portfolio'));
    }

    // Form edit portofolio
        public function edit($portfolio)
    {
        $this->checkAdmin();

        $portfolio = Portofolio::findOrFail($portfolio);

        $designers = User::where('role', 'designer')->get();

        return view('admin.portofolios.edit', compact('portfolio', 'designers'));
    }

    // Update portofolio
    public function update(Request $request, $portfolio)
    {
        $this->checkAdmin();

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
            if ($portfolio->gambar) {
                Storage::disk('public')->delete($portfolio->gambar);
            }

            $data['gambar'] = $request->file('gambar')
                ->store('portfolios', 'public');
        }

        $portfolio->update($data);

        return redirect()
            ->route('portfolios.index')
            ->with('success', 'Portofolio berhasil diperbarui.');
    }

    // Hapus portofolio
    public function destroy($portfolio)
    {
        $this->checkAdmin();

        $portfolio = Portofolio::findOrFail($portfolio);

        if ($portfolio->gambar) {
            Storage::disk('public')->delete($portfolio->gambar);
        }

        $portfolio->delete();

        return redirect()
            ->route('portfolios.index')
            ->with('success', 'Portofolio berhasil dihapus.');
    }
}