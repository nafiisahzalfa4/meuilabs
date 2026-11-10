
@extends('admin.layouts.app')

@section('title', 'Edit Layanan')
@section('page-title', 'Edit Layanan')

@section('content')
<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Edit Layanan</h4>
            <p class="text-muted mb-0">
                Perbarui informasi layanan MeUI Labs.
            </p>
        </div>

        <a href="{{ route('admin.services.index') }}"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Edit --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form action="{{ route('admin.services.update', $service->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Nama Layanan --}}
                    <div class="col-md-6 mb-3">
                        <label for="nama_jasa" class="form-label fw-semibold">
                            Nama Layanan
                        </label>

                        <input type="text"
                               name="nama_jasa"
                               id="nama_jasa"
                               class="form-control @error('nama_jasa') is-invalid @enderror"
                               value="{{ old('nama_jasa', $service->nama_jasa) }}"
                               placeholder="Masukkan nama layanan">

                        @error('nama_jasa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Harga --}}
                    <div class="col-md-6 mb-3">
                        <label for="harga" class="form-label fw-semibold">
                            Harga Layanan (Rp)
                        </label>

                        <input type="number"
                               name="harga"
                               id="harga"
                               min="0"
                               class="form-control @error('harga') is-invalid @enderror"
                               value="{{ old('harga', $service->harga) }}"
                               placeholder="Masukkan harga">

                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="col-12 mb-3">
                        <label for="deskripsi" class="form-label fw-semibold">
                            Deskripsi Layanan
                        </label>

                        <textarea name="deskripsi"
                                  id="deskripsi"
                                  rows="5"
                                  class="form-control @error('deskripsi') is-invalid @enderror"
                                  placeholder="Jelaskan tentang layanan ini...">{{ old('deskripsi', $service->deskripsi) }}</textarea>

                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Gambar Saat Ini --}}
                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">
                            Gambar Saat Ini
                        </label>

                        <div>
                            @if($service->gambar)
                                <img src="{{ asset($service->gambar) }}"
                                     alt="{{ $service->nama_jasa }}"
                                     style="width: 200px; height: 140px; object-fit: cover; border-radius: 10px;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                     style="width: 200px; height: 140px;">
                                    <span class="text-muted">Belum ada gambar</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Ganti Gambar --}}
                    <div class="col-md-6 mb-3">
                        <label for="gambar" class="form-label fw-semibold">
                            Ganti Gambar Layanan
                        </label>

                        <input type="file"
                               name="gambar"
                               id="gambar"
                               accept=".jpg,.jpeg,.png,.webp"
                               class="form-control @error('gambar') is-invalid @enderror">

                        <small class="text-muted">
                            Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                        </small>

                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label fw-semibold">
                            Status Layanan
                        </label>

                        <select name="status"
                                id="status"
                                class="form-select @error('status') is-invalid @enderror">

                            <option value="aktif"
                                {{ old('status', $service->status) == 'aktif' ? 'selected' : '' }}>
                                Aktif
                            </option>

                            <option value="nonaktif"
                                {{ old('status', $service->status) == 'nonaktif' ? 'selected' : '' }}>
                                Nonaktif
                            </option>
                        </select>

                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4">

                {{-- Tombol --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.services.index') }}"
                       class="btn btn-light border">
                        Batal
                    </a>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i>
                        Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
