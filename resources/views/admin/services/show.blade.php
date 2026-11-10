
@extends('admin.layouts.app')

@section('title', 'Detail Layanan')
@section('page-title', 'Detail Layanan')

@section('content')
<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Detail Layanan</h4>
            <p class="text-muted mb-0">
                Informasi lengkap layanan MeUI Labs.
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.services.index') }}"
               class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Kembali
            </a>

            <a href="{{ route('admin.services.edit', $service->id) }}"
               class="btn btn-warning">
                <i class="bi bi-pencil-square me-1"></i>
                Edit Layanan
            </a>
        </div>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">

        {{-- Gambar Layanan --}}
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <h5 class="fw-bold mb-3">Gambar Layanan</h5>

                    @if($service->gambar)
                        <img src="{{ asset($service->gambar) }}"
                             alt="{{ $service->nama_jasa }}"
                             class="img-fluid w-100 rounded"
                             style="max-height: 350px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded d-flex flex-column align-items-center justify-content-center"
                             style="height: 250px;">
                            <i class="bi bi-image fs-1 text-secondary"></i>
                            <span class="text-muted mt-2">
                                Belum ada gambar
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Informasi Layanan --}}
        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">Informasi Layanan</h5>

                    {{-- Nama --}}
                    <div class="mb-4">
                        <label class="text-muted small mb-1">
                            Nama Layanan
                        </label>
                        <h5 class="fw-bold mb-0">
                            {{ $service->nama_jasa }}
                        </h5>
                    </div>

                    <hr>

                    {{-- Harga --}}
                    <div class="mb-4">
                        <label class="text-muted small mb-1">
                            Harga Layanan
                        </label>
                        <h4 class="fw-bold text-success mb-0">
                            Rp {{ number_format($service->harga, 0, ',', '.') }}
                        </h4>
                    </div>

                    <hr>

                    {{-- Status --}}
                    <div class="mb-4">
                        <label class="text-muted small mb-2">
                            Status Layanan
                        </label>
                        <div>
                            @if($service->status == 'aktif')
                                <span class="badge bg-success-subtle text-success px-3 py-2">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Aktif
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger px-3 py-2">
                                    <i class="bi bi-x-circle me-1"></i>
                                    Nonaktif
                                </span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="text-muted small mb-2">
                            Deskripsi Layanan
                        </label>

                        <p class="mb-0 text-secondary"
                           style="line-height: 1.8; white-space: pre-line;">
                            {{ $service->deskripsi ?: 'Belum ada deskripsi layanan.' }}
                        </p>
                    </div>

                </div>
            </div>
        </div>

    </div>

    {{-- Tombol Hapus --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h6 class="fw-bold mb-1">Hapus Layanan</h6>
                <p class="text-muted small mb-0">
                    Layanan yang dihapus tidak dapat ditampilkan kembali.
                </p>
            </div>

            <form action="{{ route('admin.services.destroy', $service->id) }}"
                  method="POST"
                  onsubmit="return confirm('Apakah kamu yakin ingin menghapus layanan ini?')">

                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash me-1"></i>
                    Hapus Layanan
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
