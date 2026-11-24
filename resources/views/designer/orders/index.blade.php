@extends('designer.layouts.app')

@section('title', 'Pesanan Saya')
@section('page-title', 'Daftar Pekerjaan')

@section('content')

{{-- HEADER --}}
<div class="page-heading">
    <h4>Pesanan Saya</h4>
    <p>Kelola dan pantau seluruh pekerjaan yang ditugaskan kepada kamu.</p>
</div>

{{-- STATISTIK --}}
<div class="row g-3 mb-4">

    <div class="col-md-6 col-xl-4">
        <div class="content-card h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">Total Pekerjaan</small>
                    <h3 class="fw-bold mt-2 mb-0">
                        {{ $orders->total() }}
                    </h3>
                </div>

                <div class="rounded-3 p-3"
                     style="background:#e8f0f1;color:#173f46;">
                    <i class="bi bi-receipt fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-4">
        <div class="content-card h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">Diproses</small>
                    <h3 class="fw-bold mt-2 mb-0 text-primary">
                        {{ $orders->getCollection()->where('status', 'diproses')->count() }}
                    </h3>
                </div>

                <div class="rounded-3 p-3"
                     style="background:#eaf3fb;color:#3576ad;">
                    <i class="bi bi-arrow-repeat fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-4">
        <div class="content-card h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">Selesai</small>
                    <h3 class="fw-bold mt-2 mb-0 text-success">
                        {{ $orders->getCollection()->where('status', 'selesai')->count() }}
                    </h3>
                </div>

                <div class="rounded-3 p-3"
                     style="background:#eaf6ed;color:#398052;">
                    <i class="bi bi-check-circle fs-4"></i>
                </div>
            </div>
        </div>
    </div>

</div>


{{-- DAFTAR PEKERJAAN --}}
<div class="content-card">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">

        <div>
            <h6 class="fw-bold mb-1">Daftar Pekerjaan</h6>
            <small class="text-muted">
                Pesanan yang telah ditugaskan kepada kamu.
            </small>
        </div>

        <span class="text-muted small">
            Total {{ $orders->total() }} pekerjaan
        </span>

    </div>


    {{-- TABEL --}}
    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Layanan</th>
                    <th>Tanggal Pesan</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($orders as $order)

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

                    <tr>

                        {{-- ID --}}
                        <td class="fw-semibold">
                            #{{ $order->id }}
                        </td>

                        {{-- CUSTOMER --}}
                        <td>
                            <div class="fw-semibold">
                                {{ optional($order->customer)->name ?? 'Customer' }}
                            </div>

                            <small class="text-muted">
                                {{ optional($order->customer)->email ?? '-' }}
                            </small>
                        </td>

                        {{-- LAYANAN --}}
                        <td>
                            {{ optional($order->service)->nama_jasa
                                ?? optional($order->service)->nama
                                ?? '-' }}
                        </td>

                        {{-- TANGGAL --}}
                        <td>
                            {{ $order->tanggal_pesan
                                ? \Carbon\Carbon::parse($order->tanggal_pesan)->format('d/m/Y')
                                : '-' }}
                        </td>

                        {{-- HARGA --}}
                        <td class="fw-semibold">
                            Rp{{ number_format($order->total_harga ?? 0, 0, ',', '.') }}
                        </td>

                        {{-- STATUS --}}
                        <td>
                            <span class="badge bg-{{ $badgeColor }}-subtle text-{{ $badgeColor }} px-3 py-2">
                                {{ ucfirst($status) }}
                            </span>
                        </td>

                        {{-- AKSI --}}
                        <td>
                            <div class="d-flex justify-content-center">

                                <a href="{{ route('designer.orders.show', $order->id) }}"
                                   class="btn btn-sm btn-outline-info"
                                   title="Lihat Detail">

                                    <i class="bi bi-eye"></i>
                                    Detail

                                </a>

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="text-center py-5">

                            <i class="bi bi-inbox text-muted"
                               style="font-size:45px;"></i>

                            <h6 class="fw-bold mt-3">
                                Belum Ada Pekerjaan
                            </h6>

                            <p class="text-muted small mb-0">
                                Pesanan yang ditugaskan kepada kamu
                                akan muncul di halaman ini.
                            </p>

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- PAGINATION --}}
    <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap gap-2">

        <small class="text-muted">
            Menampilkan {{ $orders->firstItem() ?? 0 }}
            sampai {{ $orders->lastItem() ?? 0 }}
            dari {{ $orders->total() }} pekerjaan
        </small>

        <div>
            {{ $orders->links() }}
        </div>

    </div>

</div>

@endsection