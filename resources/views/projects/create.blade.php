
<style>
    * { box-sizing: border-box; }

    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f5f6fa;
        color: #1f2937;
    }

    .page {
        max-width: 850px;
        margin: 35px auto;
        padding: 0 20px;
    }

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

    input, select {
        width: 100%;
        padding: 12px 13px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: white;
        color: #1f2937;
        font: inherit;
        font-size: 14px;
    }

    input:focus, select:focus {
        outline: none;
        border-color: #6d5dfc;
        box-shadow: 0 0 0 3px rgba(109, 93, 252, .12);
    }

    .hint {
        margin-top: 7px;
        color: #6b7280;
        font-size: 12px;
    }

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
        <h2>Tambah Proyek</h2>
        <p>Tambahkan dan atur proyek pelanggan MeUI Labs.</p>
    </div>

    <div class="card">
        <h3 class="section-title">Informasi Proyek</h3>

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

        <form action="{{ route('projects.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="order_id">Pilih Pesanan</label>

                <select id="order_id" name="order_id" required>
                    <option value="">-- Pilih Pesanan --</option>

                    @forelse ($orders as $order)
                        <option value="{{ $order->id }}"
                            {{ old('order_id') == $order->id ? 'selected' : '' }}>
                            #{{ $order->id }} -
                            {{ $order->customer->name ?? 'Pelanggan' }} -
                            {{ $order->service->nama_jasa ?? 'Layanan' }}
                        </option>
                    @empty
                        <option value="" disabled>Tidak ada pesanan tersedia</option>
                    @endforelse
                </select>

                <div class="hint">
                    Hanya pesanan yang belum memiliki proyek yang ditampilkan.
                </div>
            </div>

            <div class="form-group">
                <label for="project_name">Nama Proyek</label>
                <input type="text"
                       id="project_name"
                       name="project_name"
                       value="{{ old('project_name') }}"
                       maxlength="100"
                       placeholder="Masukkan nama proyek"
                       required>
            </div>

            <div class="form-group">
                <label for="start_date">Tanggal Mulai</label>
                <input type="date"
                       id="start_date"
                       name="start_date"
                       value="{{ old('start_date') }}">
            </div>

            <div class="form-group">
                <label for="deadline">Tenggat Proyek</label>
                <input type="date"
                       id="deadline"
                       name="deadline"
                       value="{{ old('deadline') }}">
                <div class="hint">
                    Tanggal tenggat tidak boleh sebelum tanggal mulai.
                </div>
            </div>

            <div class="form-group">
                <label for="progress">Progress Proyek (%)</label>
                <input type="number"
                       id="progress"
                       name="progress"
                       value="{{ old('progress', 0) }}"
                       min="0"
                       max="100"
                       placeholder="0"
                       required>
                <div class="hint">Masukkan angka antara 0 sampai 100.</div>
            </div>

            <div class="form-group">
                <label for="status">Status Proyek</label>
                <select id="status" name="status" required>
                    <option value="not_started"
                        {{ old('status', 'not_started') == 'not_started' ? 'selected' : '' }}>
                        Belum Dimulai
                    </option>

                    <option value="process"
                        {{ old('status') == 'process' ? 'selected' : '' }}>
                        Sedang Diproses
                    </option>

                    <option value="revision"
                        {{ old('status') == 'revision' ? 'selected' : '' }}>
                        Revisi
                    </option>

                    <option value="completed"
                        {{ old('status') == 'completed' ? 'selected' : '' }}>
                        Selesai
                    </option>
                </select>
            </div>

            <div class="actions">
                <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                    Batal
                </a>

                <button type="submit" class="btn btn-primary">
                    Simpan Proyek
                </button>
            </div>
        </form>
    </div>
</div>
