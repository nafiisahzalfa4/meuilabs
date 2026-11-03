<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan | MeUI Labs</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
            font-family: Arial, sans-serif;
            color: #253047;
        }

        .page-wrapper {
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 24px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 28px;
        }

        .page-header h2 {
            font-weight: 700;
            margin-bottom: 7px;
        }

        .page-header p {
            color: #778197;
            margin: 0;
        }

        .table-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 5px 25px rgba(30, 50, 80, 0.06);
        }

        .table thead th {
            background: #f8f9fc;
            color: #667085;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .4px;
            white-space: nowrap;
            padding: 15px 12px;
        }

        .table tbody td {
            padding: 15px 12px;
            vertical-align: middle;
            font-size: 14px;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .btn-primary {
            background: #596be8;
            border-color: #596be8;
        }

        .btn-primary:hover {
            background: #4658d2;
            border-color: #4658d2;
        }

        .btn {
            border-radius: 8px;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-menunggu {
            background: #fff3cd;
            color: #856404;
        }

        .status-diproses {
            background: #cfe2ff;
            color: #084298;
        }

        .status-selesai {
            background: #d1e7dd;
            color: #0f5132;
        }

        .status-dibatalkan {
            background: #f8d7da;
            color: #842029;
        }

        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: #778197;
        }

        .order-number {
            font-weight: 700;
            color: #596be8;
        }
    </style>
</head>
<body>

<div class="page-wrapper">

    <div class="page-header">
        <div>
            <h2>Daftar Pesanan</h2>
            <p>Kelola dan pantau seluruh pesanan layanan MeUI Labs.</p>
        </div>

        <a href="{{ route('orders.create') }}" class="btn btn-primary px-4 py-2">
            + Tambah Pesanan
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="table-card">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Semua Pesanan</h5>
            <span class="text-secondary small">
                Total: {{ $orders->count() }} pesanan
            </span>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Customer</th>
                        <th>Designer</th>
                        <th>Jasa</th>
                        <th>Tanggal</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th style="min-width: 190px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>
                                <span class="order-number">
                                    #{{ $order->id }}
                                </span>
                            </td>

                            <td>
                                <div class="fw-semibold">
                                    {{ $order->customer->name ?? 'Customer tidak tersedia' }}
                                </div>
                                <small class="text-muted">
                                    {{ $order->customer->email ?? '-' }}
                                </small>
                            </td>

                            <td>
                                {{ $order->designer->name ?? 'Belum ditentukan' }}
                            </td>

                            <td>
                                {{ $order->service->nama_jasa ?? 'Jasa tidak tersedia' }}
                            </td>

                            <td>
                                {{ $order->tanggal_pesan
                                    ? \Carbon\Carbon::parse($order->tanggal_pesan)->format('d/m/Y')
                                    : '-' }}
                            </td>

                            <td class="fw-semibold">
                                Rp{{ number_format($order->total_harga, 0, ',', '.') }}
                            </td>

                            <td>
                                <span class="status status-{{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>

                            <td>
                                <div class="d-flex gap-1 flex-wrap">
                                    <a href="{{ route('orders.show', $order->id) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        Detail
                                    </a>

                                    <a href="{{ route('orders.edit', $order->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        Edit
                                    </a>

                                    <form action="{{ route('orders.destroy', $order->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <h6 class="fw-bold">Belum Ada Pesanan</h6>
                                    <p class="mb-3">
                                        Pesanan yang dibuat akan muncul di halaman ini.
                                    </p>
                                    <a href="{{ route('orders.create') }}"
                                       class="btn btn-primary">
                                        Tambah Pesanan Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>