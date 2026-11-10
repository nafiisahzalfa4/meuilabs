 @extends('admin.layouts.app')

@section('title', 'Tambah Layanan')
@section('page-title', 'Tambah Layanan')

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Tambah Layanan</h4>
            <p class="text-muted mb-0">Tambahkan layanan baru ke MeUI Labs.</p>
        </div>

        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form action="{{ route('admin.services.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

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
                               value="{{ old('nama_jasa') }}"
                               placeholder="Contoh: Website Development">

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
                               class="form-control @error('harga') is-invalid @enderror"
                               value="{{ old('harga') }}"
                               min="0"
                               placeholder="Contoh: 1500000">

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
                                  placeholder="Jelaskan layanan yang ditawarkan...">{{ old('deskripsi') }}</textarea>

                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Gambar --}}
                    <div class="col-md-6 mb-3">
                        <label for="gambar" class="form-label fw-semibold">
                            Gambar Layanan
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

                            <option value="">-- Pilih Status --</option>
                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>
                                Nonaktif
                            </option>
                        </select>

                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.services.index') }}"
                       class="btn btn-light border">
                        Batal
                    </a>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i> Simpan Layanan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection