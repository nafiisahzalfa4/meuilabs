<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pesanan | MeUI Labs</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
            font-family: Arial, sans-serif;
            color: #253047;
        }

        .page-wrapper {
            max-width: 950px;
            margin: 45px auto;
            padding: 0 20px;
        }

        .page-header {
            margin-bottom: 25px;
        }

        .page-header h2 {
            font-weight: 700;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #778197;
            margin: 0;
        }

        .form-card {
            background: #fff;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 5px 25px rgba(30, 50, 80, 0.06);
        }

        .section-title {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border: 1px solid #dfe4ec;
            border-radius: 9px;
            padding: 11px 13px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #6578e8;
            box-shadow: 0 0 0 3px rgba(101, 120, 232, 0.12);
        }

        .btn-primary {
            background: #596be8;
            border-color: #596be8;
            border-radius: 9px;
            padding: 11px 22px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: #4658d2;
            border-color: #4658d2;
        }

        .btn-secondary {
            border-radius: 9px;
            padding: 11px 22px;
        }

        .required {
            color: #dc3545;
        }

        @media (max-width: 576px) {
            .form-card {
                padding: 22px 17px;
            }

            .page-wrapper {
                margin-top: 25px;
            }
        }
    </style>
</head>
<body>

<div class="page-wrapper">

    <div class="page-header">
        <a href="{{ route('orders.index') }}"
           class="text-decoration-none text-secondary small">
            &larr; Kembali ke daftar pesanan
        </a>

        <h2 class="mt-3">Tambah Pesanan</h2>
        <p>Lengkapi informasi untuk menambahkan pesanan baru.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Periksa kembali data yang kamu masukkan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="form-card">

        <form action="{{ route('orders.store') }}"
              method="POST">

            @csrf

            <h5 class="section-title">Informasi Pelanggan</h5>

            <div class="mb-3">
                <label for="customer_id" class="form-label">
                    Customer <span class="required">*</span>
                </label>

                <select name="customer_id" id="customer_id"
                        class="form-select" required>
                    <option value="">Pilih customer</option>

                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}"
                            {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }} — {{ $customer->email }}
                        </option>
                    @endforeach
                </select>

                @if ($customers->isEmpty())
                    <small class="text-danger">
                        Belum ada akun dengan role customer di tabel users.
                    </small>
                @endif
            </div>

            <div class="mb-4">
                <label for="designer_id" class="form-label">
                    Designer
                </label>

                <select name="designer_id" id="designer_id"
                        class="form-select">
                    <option value="">Belum ditentukan</option>

                    @foreach ($designers as $designer)
                        <option value="{{ $designer->id }}"
                            {{ old('designer_id') == $designer->id ? 'selected' : '' }}>
                            {{ $designer->name }}
                        </option>
                    @endforeach
                </select>

                @if ($designers->isEmpty())
                    <small class="text-muted">
                        Belum ada designer terdaftar. Pesanan bisa dibuat tanpa designer.
                    </small>
                @endif
            </div>

            <hr class="my-4">

            <h5 class="section-title">Detail Pesanan</h5>

            <div class="mb-3">
                <label for="service_id" class="form-label">
                    Jasa <span class="required">*</span>
                </label>

                <select name="service_id" id="service_id"
                        class="form-select" required>
                    <option value="">Pilih jasa</option>

                    @foreach ($services as $service)
                        <option value="{{ $service->id }}"
                                data-harga="{{ $service->harga }}"
                            {{ old('service_id') == $service->id ? 'selected' : '' }}>
                            {{ $service->nama_jasa }} —
                            Rp{{ number_format($service->harga, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>

                @if ($services->isEmpty())
                    <small class="text-danger">
                        Belum ada jasa aktif. Tambahkan atau aktifkan jasa terlebih dahulu.
                    </small>
                @endif
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tanggal_pesan" class="form-label">
                        Tanggal Pesan <span class="required">*</span>
                    </label>

                    <input type="date" name="tanggal_pesan"
                           id="tanggal_pesan"
                           class="form-control"
                           value="{{ old('tanggal_pesan', date('Y-m-d')) }}"
                           required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="total_harga" class="form-label">
                        Total Harga (Rp) <span class="required">*</span>
                    </label>

                    <input type="number" name="total_harga"
                           id="total_harga"
                           class="form-control"
                           min="0" step="0.01"
                           value="{{ old('total_harga') }}"
                           placeholder="Contoh: 500000"
                           required>
                    <small class="text-muted">
                        Harga otomatis mengikuti jasa yang dipilih, tetapi bisa diubah.
                    </small>
                </div>
            </div>

            <div class="mb-3">
                <label for="catatan" class="form-label">
                    Catatan Pesanan
                </label>

                <textarea name="catatan" id="catatan"
                          class="form-control" rows="4"
                          placeholder="Tuliskan kebutuhan atau detail pesanan...">{{ old('catatan') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="status" class="form-label">
                    Status Pesanan <span class="required">*</span>
                </label>

                <select name="status" id="status"
                        class="form-select" required>
                    <option value="menunggu"
                        {{ old('status', 'menunggu') == 'menunggu' ? 'selected' : '' }}>
                        Menunggu
                    </option>
                    <option value="diproses"
                        {{ old('status') == 'diproses' ? 'selected' : '' }}>
                        Diproses
                    </option>
                    <option value="selesai"
                        {{ old('status') == 'selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>
                    <option value="dibatalkan"
                        {{ old('status') == 'dibatalkan' ? 'selected' : '' }}>
                        Dibatalkan
                    </option>
                </select>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2 flex-wrap">
                <a href="{{ route('orders.index') }}"
                   class="btn btn-secondary">
                    Batal
                </a>

                <button type="submit" class="btn btn-primary"
                    {{ $customers->isEmpty() || $services->isEmpty() ? 'disabled' : '' }}>
                    Simpan Pesanan
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    const serviceSelect = document.getElementById('service_id');
    const totalHarga = document.getElementById('total_harga');

    serviceSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const harga = selectedOption.getAttribute('data-harga');

        if (harga !== null && harga !== '') {
            totalHarga.value = harga;
        }
    });
</script>

</body>
</html>