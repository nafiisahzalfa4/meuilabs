
@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')

{{-- HEADER DASHBOARD --}}
<div class="page-heading d-flex flex-wrap justify-content-between align-items-center gap-3">
    <div>
        <h4>Dashboard Admin</h4>
        <p>Selamat datang kembali! Berikut ringkasan aktivitas MeUI Labs.</p>
    </div>

    <div class="text-muted small">
        <i class="bi bi-calendar3 me-1"></i>
        {{ now()->translatedFormat('l, d F Y') }}
    </div>
</div>


{{-- STATISTIK UTAMA --}}
<div class="row g-3 mb-4">

    {{-- TOTAL PENGGUNA --}}
    <div class="col-xl-3 col-md-6">
        <div class="content-card h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted small mb-2">Total Pengguna</p>
                    <h3 class="fw-bold mb-1">{{ $totalUsers }}</h3>
                    <small class="text-muted">Seluruh akun terdaftar</small>
                </div>

                <div class="rounded-3 p-3" style="background:#e8f0f1;color:#173f46;">
                    <i class="bi bi-people-fill fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- TOTAL CUSTOMER --}}
    <div class="col-xl-3 col-md-6">
        <div class="content-card h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted small mb-2">Customer</p>
                    <h3 class="fw-bold mb-1">{{ $totalCustomers }}</h3>
                    <small class="text-muted">Pengguna layanan</small>
                </div>

                <div class="rounded-3 p-3" style="background:#eaf3ed;color:#398052;">
                    <i class="bi bi-person-check-fill fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- TOTAL DESIGNER --}}
    <div class="col-xl-3 col-md-6">
        <div class="content-card h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted small mb-2">Designer</p>
                    <h3 class="fw-bold mb-1">{{ $totalDesigners }}</h3>
                    <small class="text-muted">Tim kreatif MeUI Labs</small>
                </div>

                <div class="rounded-3 p-3" style="background:#f1ecf8;color:#7952a0;">
                    <i class="bi bi-person-workspace fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- TOTAL PESANAN --}}
    <div class="col-xl-3 col-md-6">
        <div class="content-card h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted small mb-2">Total Pesanan</p>
                    <h3 class="fw-bold mb-1">{{ $totalOrders }}</h3>
                    <small class="text-muted">Seluruh pesanan masuk</small>
                </div>

                <div class="rounded-3 p-3" style="background:#fff3e5;color:#d28a31;">
                    <i class="bi bi-receipt-cutoff fs-4"></i>
                </div>
            </div>
        </div>
    </div>

</div>


{{-- STATISTIK TAMBAHAN --}}
<div class="row g-3 mb-4">

    <div class="col-xl-4 col-md-6">
        <div class="content-card h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-3" style="background:#e8f0f1;color:#173f46;">
                    <i class="bi bi-briefcase-fill fs-4"></i>
                </div>
                <div>
                    <p class="text-muted small mb-1">Total Layanan</p>
                    <h4 class="fw-bold mb-0">{{ $totalServices }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="content-card h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-3" style="background:#f1ecf8;color:#7952a0;">
                    <i class="bi bi-images fs-4"></i>
                </div>
                <div>
                    <p class="text-muted small mb-1">Total Portfolio</p>
                    <h4 class="fw-bold mb-0">{{ $totalPortfolios }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="content-card h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-3" style="background:#fff3e5;color:#d28a31;">
                    <i class="bi bi-kanban-fill fs-4"></i>
                </div>
                <div>
                    <p class="text-muted small mb-1">Total Project</p>
                    <h4 class="fw-bold mb-0">{{ $totalProjects }}</h4>
                </div>
            </div>
        </div>
    </div>

</div>


{{-- STATUS PESANAN --}}
<div class="content-card mb-4">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h6 class="fw-bold mb-1">Ringkasan Status Pesanan</h6>
            <small class="text-muted">Pantau perkembangan seluruh pesanan.</small>
        </div>

        <a href="{{ route('admin.orders.index') }}"
           class="btn-primary-custom">
            Lihat Semua Pesanan
            <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="row g-3">

        <div class="col-md-3 col-6">
            <div class="p-3 rounded-3 h-100" style="background:#fff8e8;">
                <div class="text-warning mb-2">
                    <i class="bi bi-hourglass-split fs-4"></i>
                </div>
                <h4 class="fw-bold mb-1">{{ $pendingOrders }}</h4>
                <small class="text-muted">Menunggu</small>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="p-3 rounded-3 h-100" style="background:#eaf3fb;">
                <div class="text-primary mb-2">
                    <i class="bi bi-arrow-repeat fs-4"></i>
                </div>
                <h4 class="fw-bold mb-1">{{ $processingOrders }}</h4>
                <small class="text-muted">Diproses</small>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="p-3 rounded-3 h-100" style="background:#eaf6ed;">
                <div class="text-success mb-2">
                    <i class="bi bi-check-circle-fill fs-4"></i>
                </div>
                <h4 class="fw-bold mb-1">{{ $completedOrders }}</h4>
                <small class="text-muted">Selesai</small>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="p-3 rounded-3 h-100" style="background:#fceeee;">
                <div class="text-danger mb-2">
                    <i class="bi bi-x-circle-fill fs-4"></i>
                </div>
                <h4 class="fw-bold mb-1">{{ $cancelledOrders }}</h4>
                <small class="text-muted">Dibatalkan</small>
            </div>
        </div>

    </div>
</div>


{{-- PESANAN TERBARU --}}
<div class="content-card">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h6 class="fw-bold mb-1">Pesanan Terbaru</h6>
            <small class="text-muted">Lima pesanan terakhir yang masuk ke sistem.</small>
        </div>

        <a href="{{ route('admin.orders.index') }}"
           class="text-decoration-none small fw-semibold"
           style="color:#173f46;">
            Lihat Semua
            <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Layanan</th>
                    <th>Tanggal</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($latestOrders as $order)

                    <tr>
                        <td class="fw-semibold">
                            #{{ $order->id }}
                        </td>

                        <td>
                            {{ $order->customer->name ?? $order->customer->nama ?? 'Customer' }}
                        </td>

                        <td>
                            {{ $order->service->nama_jasa ?? $order->service->nama ?? 'Layanan' }}
                        </td>

                        <td>
                            {{ $order->tanggal_pesan
                                ? \Carbon\Carbon::parse($order->tanggal_pesan)->format('d/m/Y')
                                : '-' }}
                        </td>

                        <td class="fw-semibold">
                            Rp{{ number_format($order->total_harga ?? 0, 0, ',', '.') }}
                        </td>

                        <td>
                            @php
                                $statusColors = [
                                    'menunggu' => 'warning',
                                    'diproses' => 'primary',
                                    'selesai' => 'success',
                                    'dibatalkan' => 'danger',
                                ];

                                $status = strtolower($order->status ?? 'menunggu');
                                $badgeColor = $statusColors[$status] ?? 'secondary';
                            @endphp

                            <span class="badge bg-{{ $badgeColor }}-subtle text-{{ $badgeColor }} px-3 py-2">
                                {{ ucfirst($status) }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                               class="btn btn-sm btn-outline-secondary"
                               title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-2 mb-0">
                                Belum ada pesanan yang masuk.
                            </p>
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>
</div>

@endsection
