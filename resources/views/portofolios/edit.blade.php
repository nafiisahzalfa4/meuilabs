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

    .preview {
        display: block;
        width: 220px;
        max-width: 100%;
        max-height: 160px;
        object-fit: cover;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        margin-bottom: 12px;
    }

    .no-image {
        width: 220px;
        max-width: 100%;
        height: 110px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        border-radius: 10px;
        background: #f3f4f6;
        color: #9ca3af;
        font-size: 12px;
    }

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
        <h2>Edit Portofolio</h2>
        <p>Perbarui informasi dan preview hasil desain UI/UX.</p>
    </div>

    <div class="card">
        <h3 class="section-title">Informasi Proyek Desain</h3>

        @if ($errors->any())
            <div class="error">
                <strong>Data belum bisa diperbarui.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('portfolios.update', $portfolio->id) }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label for="judul">Judul Proyek</label>
                    <input id="judul" type="text" name="judul"
                           value="{{ old('judul', $portfolio->judul) }}"
                           maxlength="100" required>
                </div>

                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select id="kategori" name="kategori" required>
                        <option value="website" {{ old('kategori', $portfolio->kategori) == 'website' ? 'selected' : '' }}>Website</option>
                        <option value="mobile" {{ old('kategori', $portfolio->kategori) == 'mobile' ? 'selected' : '' }}>Mobile App</option>
                        <option value="dashboard" {{ old('kategori', $portfolio->kategori) == 'dashboard' ? 'selected' : '' }}>Dashboard</option>
                        <option value="lainnya" {{ old('kategori', $portfolio->kategori) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div class="form-group full">
                    <label for="deskripsi">Deskripsi Proyek</label>
                    <textarea id="deskripsi" name="deskripsi"
                              placeholder="Jelaskan tujuan dan solusi desain...">{{ old('deskripsi', $portfolio->deskripsi) }}</textarea>
                </div>

                <div class="form-group full">
                    <label>Gambar Saat Ini</label>

                    @if ($portfolio->gambar)
                        <img
                            src="{{ asset('storage/' . $portfolio->gambar) }}"
                            alt="Preview {{ $portfolio->judul }}"
                            class="preview"
                        >
                    @else
                        <div class="no-image">Belum ada gambar</div>
                    @endif

                    <label for="gambar">Ganti Gambar Preview</label>
                    <input id="gambar" type="file" name="gambar"
                           accept=".jpg,.jpeg,.png,.webp">
                    <div class="hint">
                        Kosongkan jika tidak ingin mengganti gambar. Format JPG, JPEG, PNG, atau WEBP; maksimal 2 MB.
                    </div>
                </div>

                @if ($designers->isNotEmpty())
                    <div class="form-group full">
                        <label for="designer_id">Designer Pemilik</label>
                        <select id="designer_id" name="designer_id" required>
                            <option value="">Pilih designer</option>
                            @foreach ($designers as $designer)
                                <option value="{{ $designer->id }}"
                                    {{ (string) old('designer_id', $portfolio->designer_id) === (string) $designer->id ? 'selected' : '' }}>
                                    {{ $designer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>

            <div class="actions">
                <a href="{{ route('portfolios.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div> 