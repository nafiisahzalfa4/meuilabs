
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

    .form-group { margin-bottom: 20px; }

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
    .btn-secondary { background: #f3f4f6; color: #374151; }

    @media (max-width: 600px) {
        .page { margin: 20px auto; padding: 0 12px; }
        .card { padding: 20px; }
    }
</style>

<div class="page">
    <div class="page-header">
        <h2>Tambah Layanan</h2>
        <p>Tambahkan layanan baru yang ditawarkan MeUI Labs.</p>
    </div>

    <div class="card">
        <h3 class="section-title">Informasi Layanan</h3>

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

        <form action="{{ route('services.store') }}" method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="nama_jasa">Nama Layanan <span class="required">*</span></label>
                <input type="text" id="nama_jasa" name="nama_jasa"
                       value="{{ old('nama_jasa') }}"
                       maxlength="100"
                       placeholder="Contoh: UI/UX Design Website" required>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi Layanan</label>
                <textarea id="deskripsi" name="deskripsi"
                          placeholder="Jelaskan detail layanan...">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="form-group">
                <label for="harga">Harga (Rp) <span class="required">*</span></label>
                <input type="number" id="harga" name="harga"
                       value="{{ old('harga') }}"
                       min="0" step="0.01"
                       placeholder="Contoh: 500000" required>
            </div>

            <div class="form-group">
                <label for="gambar">Gambar Layanan</label>
                <input type="file" id="gambar" name="gambar"
                       accept=".jpg,.jpeg,.png,.webp">
                <div class="hint">Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.</div>
            </div>

            <div class="form-group">
                <label for="status">Status <span class="required">*</span></label>
                <select id="status" name="status" required>
                    <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="actions">
                <a href="{{ route('services.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Layanan</button>
            </div>
        </form>
    </div>
</div>
