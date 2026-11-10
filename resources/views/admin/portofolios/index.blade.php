
@extends('admin.layouts.app')

@section('title', 'Data Portofolio')
@section('page-title', 'Data Portofolio')

@section('content')

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h5 class="fw-bold mb-1">Manajemen Portofolio</h5>
                <p class="text-muted mb-0">
                    Kelola hasil karya dan proyek MeUI Labs.
                </p>
            </div>

            <a href="{{ route('admin.portfolios.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>
                Tambah Portofolio
            </a>
        </div>
    </div>
</div>

{{-- Statistik --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-3 bg-primary bg-opacity-10 p-3 me-3">
                    <i class="bi bi-images text-primary fs-3"></i>
                </div>
                <div>
                    <p class="text-muted mb-1 small">Total Portofolio</p>
                    <h4 class="fw-bold mb-0">{{ $portfolios->total() }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-3 bg-success bg-opacity-10 p-3 me-3">
                    <i class="bi bi-laptop text-success fs-3"></i>
                </div>
                <div>
                    <p class="text-muted mb-1 small">Kategori Website</p>
                    <h4 class="fw-bold mb-0">
                        {{ \App\Portofolio::where('kategori', 'website')->count() }}
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-3 bg-warning bg-opacity-10 p-3 me-3">
                    <i class="bi bi-phone text-warning fs-3"></i>
                </div>
                <div>
                    <p class="text-muted mb-1 small">Kategori Mobile</p>
                    <h4 class="fw-bold mb-0">
                        {{ \App\Portofolio::where('kategori', 'mobile')->count() }}
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Daftar Portofolio --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h5 class="fw-bold mb-1">Daftar Portofolio</h5>
                <p class="text-muted small mb-0">
                    Semua hasil karya yang tersimpan dalam sistem.
                </p>
            </div>

            <form action="{{ route('admin.portfolios.index') }}" method="GET"
                  class="d-flex gap-2">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Cari portofolio..."
                       value="{{ request('search') }}">

                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-search"></i>
                </button>

                @if(request('search'))
                    <a href="{{ route('admin.portfolios.index') }}"
                       class="btn btn-light border">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table align-middle table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="60">No.</th>
                        <th width="110">Gambar</th>
                        <th>Judul Portofolio</th>
                        <th>Kategori</th>
                        <th>Desainer</th>
                        <th width="170" class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($portfolios as $portfolio)
                        <tr>
                            <td>
                                {{ $portfolios->firstItem() + $loop->index }}
                            </td>

                            <td>
                                @if($portfolio->gambar)
                                    <img src="{{ asset('storage/' . $portfolio->gambar) }}"
                                         alt="{{ $portfolio->judul }}"
                                         class="rounded"
                                         style="width: 85px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                         style="width: 85px; height: 60px;">
                                        <i class="bi bi-image text-muted fs-3"></i>
                                    </div>
                                @endif
                            </td>

                            <td>
                                <div class="fw-semibold">
                                    {{ $portfolio->judul }}
                                </div>
                                <small class="text-muted">
                                    {{ \Illuminate\Support\Str::limit($portfolio->deskripsi, 55) }}
                                </small>
                            </td>

                            <td>
                                @php
                                    $kategoriClass = [
                                        'website' => 'bg-primary',
                                        'mobile' => 'bg-success',
                                        'dashboard' => 'bg-info text-dark',
                                        'lainnya' => 'bg-secondary',
                                    ][$portfolio->kategori] ?? 'bg-secondary';
                                @endphp

                                <span class="badge {{ $kategoriClass }}">
                                    {{ ucfirst($portfolio->kategori ?? 'Lainnya') }}
                                </span>
                            </td>

                            <td>
                                {{ $portfolio->designer->name ?? $portfolio->designer->nama ?? 'Belum ditentukan' }}
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('admin.portfolios.show', $portfolio->id) }}"
                                       class="btn btn-sm btn-outline-info"
                                       title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.portfolios.edit', $portfolio->id) }}"
                                       class="btn btn-sm btn-outline-warning"
                                       title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('admin.portfolios.destroy', $portfolio->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus portofolio ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-folder2-open fs-1 text-muted"></i>
                                <h6 class="fw-bold mt-3">Belum Ada Portofolio</h6>
                                <p class="text-muted small mb-3">
                                    Belum ada data portofolio yang ditambahkan.
                                </p>
                                <a href="{{ route('admin.portfolios.create') }}"
                                   class="btn btn-primary btn-sm">
                                    <i class="bi bi-plus-lg me-1"></i>
                                    Tambah Portofolio
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
            <small class="text-muted">
                Menampilkan {{ $portfolios->count() }} dari {{ $portfolios->total() }} data.

                {{ $portfolios->withQueryString()->links() }}
        </div>

    </div>
</div>

@endsection
