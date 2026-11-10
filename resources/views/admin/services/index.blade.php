
@extends('admin.layouts.app')

@section('title', 'Manajemen Layanan')
@section('page-title', 'Manajemen Layanan')

@section('content')
<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Manajemen Layanan</h4>
            <p class="text-muted mb-0">
                Kelola layanan yang tersedia di MeUI Labs.
            </p>
        </div>

        <a href="{{ route('admin.services.create') }}"
           class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i>
            Tambah Layanan
        </a>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tabel Layanan --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Daftar Layanan</h5>
                <span class="badge bg-light text-dark">
                    Total: {{ $services->count() }} layanan
                </span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Gambar</th>
                            <th>Nama Layanan</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($services as $service)
                            <tr>
                                <td class="ps-4">
                                    {{ $loop->iteration }}
                                </td>

                                {{-- Gambar --}}
                                <td>
                                    @if($service->gambar)
                                        <img
                                            src="{{ asset($service->gambar) }}"
                                            alt="{{ $service->nama_jasa }}"
                                            width="75"
                                            height="55"
                                            style="object-fit: cover; border-radius: 8px;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                             style="width: 75px; height: 55px;">
                                            <i class="bi bi-image text-secondary fs-4"></i>
                                        </div>
                                    @endif
                                </td>

                                {{-- Nama --}}
                                <td>
                                    <span class="fw-semibold">
                                        {{ $service->nama_jasa }}
                                    </span>
                                    <div class="text-muted small">
                                        {{ \Illuminate\Support\Str::limit($service->deskripsi, 55) }}
                                    </div>
                                </td>

                                {{-- Harga --}}
                                <td>
                                    Rp {{ number_format($service->harga, 0, ',', '.') }}
                                </td>

                                {{-- Status --}}
                                <td>
                                    @if($service->status == 'aktif')
                                        <span class="badge bg-success-subtle text-success">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">

                                        <a href="{{ route('admin.services.edit', $service->id) }}"
                                           class="btn btn-sm btn-warning"
                                           title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('admin.services.destroy', $service->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
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
                                    <i class="bi bi-inbox fs-1 text-muted"></i>
                                    <p class="text-muted mt-2 mb-0">
                                        Belum ada layanan yang ditambahkan.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
