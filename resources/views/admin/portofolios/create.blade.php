
@extends('admin.layouts.app')

@section('title', 'Tambah Portofolio')
@section('page-title', 'Tambah Portofolio')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <div class="mb-4">
            <h5 class="fw-bold mb-1">Tambah Portofolio Baru</h5>
            <p class="text-muted mb-0">
                Masukkan informasi karya yang ingin ditampilkan.
            </p>
        </div>

        <form action="{{ route('admin.portfolios.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="judul" class="form-label fw-semibold">
                        Judul Portofolio <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="judul"
                           id="judul"
                           class="form-control @error('judul') is-invalid @enderror"
                           value="{{ old('judul') }}"
                           placeholder="Contoh: Website Company Profile"
                           maxlength="100"
                           required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="kategori" class="form-label fw-semibold">
                        Kategori <span class="text-danger">*</span>
                    </label>
                    <select name="kategori"
                            id="kategori"
                            class="form-select @error('kategori') is-invalid @enderror"
                            required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="website" {{ old('kategori') == 'website' ? 'selected' : '' }}>Website</option>
                        <option value="mobile" {{ old('kategori') == 'mobile' ? 'selected' : '' }}>Mobile</option>
                        <option value="dashboard" {{ old('kategori') == 'dashboard' ? 'selected' : '' }}>Dashboard</option>
                        <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label for="deskripsi" class="form-label fw-semibold">
                        Deskripsi Portofolio
                    </label>
                    <textarea name="deskripsi"
                              id="deskripsi"
                              rows="5"
                              class="form-control @error('deskripsi') is-invalid @enderror"
                              placeholder="Jelaskan secara singkat tentang proyek ini...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="designer_id" class="form-label fw-semibold">
                        Desainer
                    </label>
                    <select name="designer_id"
                            id="designer_id"
                            class="form-select @error('designer_id') is-invalid @enderror">
                        <option value="">-- Pilih Desainer --</option>
                        @foreach($designers as $designer)
                            <option value="{{ $designer->id }}"
                                {{ old('designer_id') == $designer->id ? 'selected' : '' }}>
                                {{ $designer->name ?? $designer->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('designer_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="gambar" class="form-label fw-semibold">
                        Gambar Portofolio <span class="text-danger">*</span>
                    </label>
                    <input type="file"
                           name="gambar"
                           id="gambar"
                           accept=".jpg,.jpeg,.png,.webp"
                           class="form-control @error('gambar') is-invalid @enderror"
                           required>
                    <small class="text-muted">
                        Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                    </small>
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="mt-3">
                        <img id="preview-gambar"
                             src=""
                             alt="Preview gambar"
                             class="img-thumbnail d-none"
                             style="max-width: 220px; max-height: 160px; object-fit: cover;">
                    </div>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.portfolios.index') }}"
                   class="btn btn-light border">
                    Batal
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>
                    Simpan Portofolio
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('gambar').addEventListener('change', function(event) {
        const preview = document.getElementById('preview-gambar');
        const file = event.target.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
        } else {
            preview.src = '';
            preview.classList.add('d-none');
        }
    });
</script>
@endpush
