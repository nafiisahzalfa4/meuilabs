
@extends('customer.layouts.app')

@section('title', 'Dashboard Customer')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    .dashboard-heading {
        margin-bottom: 25px;
    }

    .dashboard-heading h4 {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .dashboard-heading p {
        font-size: 13px;
        color: #839096;
        margin: 0;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: white;
        padding: 22px;
        border-radius: 12px;
        border: 1px solid #edf0f1;
        box-shadow: 0 3px 12px rgba(0,0,0,.025);
    }

    .stat-card p {
        color: #839096;
        font-size: 12px;
        margin-bottom: 12px;
    }

    .stat-card h3 {
        font-size: 27px;
        font-weight: 700;
        color: #173f46;
        margin: 0;
    }

    .stat-icon {
        width: 38px;
        height: 38px;
        border-radius: 9px;
        background: #e4eff0;
        color: #173f46;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin-bottom: 15px;
    }

    .dashboard-section {
        background: white;
        border: 1px solid #edf0f1;
        border-radius: 12px;
        padding: 22px;
        box-shadow: 0 3px 12px rgba(0,0,0,.025);
        margin-bottom: 25px;
    }

    .section-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .section-heading h5 {
        font-size: 16px;
        font-weight: 700;
        margin: 0;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .status {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        white-space: nowrap;
    }

    .status.menunggu {
        background: #fff0c2;
        color: #946500;
    }

    .status.diproses {
        background: #dceeff;
        color: #1765a5;
    }

    .status.selesai {
        background: #d9f5e4;
        color: #187642;
    }

    .status.dibatalkan {
        background: #ffe0e0;
        color: #b52d2d;
    }

    .empty-state {
        text-align: center;
        padding: 35px 15px;
        color: #839096;
    }

    .empty-state i {
        font-size: 35px;
        margin-bottom: 12px;
        display: block;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    @media (max-width: 1000px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .stats-grid,
        .summary-grid {
            grid-template-columns: 1fr;
        }

        .section-heading {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')

    <!-- HEADING -->
    <div class="dashboard-heading">
        <h4>Dashboard Customer</h4>
        <p>Selamat datang, {{ $user->name }}! Kelola pesanan layananmu di sini.</p>
    </div>

    <!-- STATISTIK -->
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-receipt"></i>
            </div>
            <p>Total Pesanan</p>
            <h3>{{ $totalOrders }}</h3>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-clock-history"></i>
            </div>
            <p>Menunggu</p>
            <h3>{{ $pendingOrders }}</h3>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-gear"></i>
            </div>
            <p>Diproses</p>
            <h3>{{ $processingOrders }}</h3>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-check-circle"></i>
            </div>
            <p>Selesai</p>
            <h3>{{ $completedOrders }}</h3>
        </div>

    </div>

    <!-- PESANAN TERBARU -->
    <div class="dashboard-section">

        <div class="section-heading">
            <h5>Pesanan Terbaru</h5>

            <a href="{{ route('customer.orders.index') }}"
               class="btn-primary-custom">
                Lihat Semua Pesanan
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        @if($latestOrders->count() > 0)

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Layanan</th>
                            <th>Designer</th>
                            <th>Tanggal</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($latestOrders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>

                                <td>
                                    {{ $order->service->nama_jasa ?? '-' }}
                                </td>

                                <td>
                                    {{ $order->designer->name ?? 'Belum ditentukan' }}
                                </td>

                                <td>
                                    {{ $order->tanggal_pesan
                                        ? \Carbon\Carbon::parse($order->tanggal_pesan)->format('d-m-Y')
                                        : '-' }}
                                </td>

                                <td>
                                    Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}
                                </td>

                                <td>
                                    <span class="status {{ $order->status }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else

            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h6>Belum Ada Pesanan</h6>
                <p>Kamu belum memiliki pesanan. Yuk, pilih layanan yang tersedia!</p>

                <a href="{{ route('services.index') }}"
                   class="btn-primary-custom">
                    Jelajahi Layanan
                </a>
            </div>

        @endif

    </div>

    <!-- RINGKASAN -->
    <div class="summary-grid">

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-x-circle"></i>
            </div>
            <p>Pesanan Dibatalkan</p>
            <h3>{{ $cancelledOrders }}</h3>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <p>Total Pesanan Aktif</p>
            <h3>{{ $pendingOrders + $processingOrders }}</h3>
        </div>

    </div>

@endsection
