<style>
    * { box-sizing: border-box; }

    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f5f6fa;
        color: #1f2937;
    }

    .page { max-width: 850px; margin: 35px auto; padding: 0 20px; }
    .page-header { margin-bottom: 22px; }
    .page-header h2 { margin: 0 0 8px; font-size: 26px; }
    .page-header p { margin: 0; color: #6b7280; font-size: 14px; }

    .card {
        background: white;
        padding: 28px;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
    }

    .section-title {
        margin: 0 0 22px;
        padding-bottom: 14px;
        border-bottom: 1px solid #e5e7eb;
        font-size: 17px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .form-group { margin-bottom: 20px; }
    .form-group.full { grid-column: 1 / -1; }

    label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 600;
    }

    .required { color: #dc2626; }

    input, select, textarea {
        width: 100%;
        padding: 12px 13px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: white;
        color: #1f2937;
        font: inherit;
        font-size: 14px;
    }

    textarea { min-height: 120px; resize: vertical; }

    input:focus, select:focus, textarea:focus {
        outline: none;
        border-color: #6d5dfc;
        box-shadow: 0 0 0 3px rgba(109, 93, 252, .12);
    }

    .hint { margin-top: 7px; color: #6b7280; font-size: 12px; }

    .error {
        margin-bottom: 22px;
        padding: 14px 16px;
        color: #991b1b;
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 8px;
        font-size: 14px;
    }

    .error ul { margin: 8px 0 0; padding-left: 20px; }

    .actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 10px;
        padding-top: 22px;
        border-top: 1px solid #e5e7eb;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 11px 18px;
        border: 0;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-primary { background: #6d5dfc; color: white; }
    .btn-primary:hover { background: #5948ed; }
    .btn-secondary { background: #f3f4f6; color: #374151; }
    .btn-secondary:hover { background: #e5e7eb; }

    @media (max-width: 600px) {
        .page { margin: 20px auto; padding: 0 12px; }
        .card { padding: 20px; }
        .form-grid { grid-template-columns: 1fr; gap: 0; }
        .form-group.full { grid-column: auto; }
    }
</style>

@php
    $designers = $designers ?? collect();
@endphp

<div class="page">
    <div class="page-header">
        <h2>Tambah Portofolio</h2>
        <p>Tambahkan hasil karya desain UI/UX ke portofolio MeUI Labs.</p>
    </div>

    <div class="card">
        <h3 class="section-title">Informasi Proyek Desain</h3>

        @if ($errors->any())
            <div class="error">
                <strong>Data belum bisa disimpan.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('portfolios.store') }}" method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label for="judul">Judul Proyek <span class="required">*</span></label>
                    <input id="judul" type="text" name="judul"
                           value="{{ old('judul') }}" maxlength="100"
                           placeholder="Contoh: Desain Website UMKM" required>
                </div>

                <div class="form-group">
                    <label for="kategori">Kategori <span class="required">*</span></label>
                    <select id="kategori" name="kategori" required>
                        <option value="">Pilih kategori</option>
                        <option value="website" {{ old('kategori', 'website') == 'website' ? 'selected' : '' }}>Website</option>
                        <option value="mobile" {{ old('kategori') == 'mobile' ? 'selected' : '' }}>Mobile App</option>
                        <option value="dashboard" {{ old('kategori') == 'dashboard' ? 'selected' : '' }}>Dashboard</option>
                        <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div class="form-group full">
                    <label for="deskripsi">Deskripsi Proyek</label>
                    <textarea id="deskripsi" name="deskripsi"
                              placeholder="Jelaskan tujuan desain, kebutuhan pengguna, dan solusi yang dibuat...">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="form-group full">
                    <label for="gambar">Gambar Preview Desain</label>
                    <input id="gambar" type="file" name="gambar"
                           accept=".jpg,.jpeg,.png,.webp">
                    <div class="hint">
                        Gunakan screenshot desain UI/UX yang jelas. Format JPG, JPEG, PNG, atau WEBP; maksimal 2 MB.
                    </div>
                </div>

                @if ($designers->isNotEmpty())
                    <div class="form-group full">
                        <label for="designer_id">Designer Pemilik <span class="required">*</span></label>
                        <select id="designer_id" name="designer_id" required>
                            <option value="">Pilih designer</option>
                            @foreach ($designers as $designer)
                                <option value="{{ $designer->id }}"
                                    {{ (string) old('designer_id', auth()->user() && auth()->user()->role === 'designer' ? auth()->id() : '') === (string) $designer->id ? 'selected' : '' }}>
                                    {{ $designer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>

            <div class="actions">
                <a href="{{ route('portfolios.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Portofolio</button>
            </div>
        </form>
    </div>
</div>