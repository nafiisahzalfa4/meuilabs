
@extends('admin.layouts.app')

@section('title', 'Data Pesanan')
@section('page-title', 'Manajemen Pesanan')

@section('content')

{{-- HEADER --}}
<div class="page-heading d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h4>Manajemen Pesanan</h4>
        <p>Kelola dan pantau seluruh pesanan pelanggan MeUI Labs.</p>
    </div>

    <a href="{{ route('admin.orders.create') }}" class="btn-primary-custom">
        <i class="bi bi-plus-lg me-1"></i>
        Tambah Pesanan
    </a>
</div>


{{-- STATISTIK PESANAN --}}
<div class="row g-3 mb-4">

    <div class="col-xl-3 col-md-6">
        <div class="content-card h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">Total Pesanan</small>
                    <h3 class="fw-bold mt-2 mb-0">
                        {{ $orders->total() }}
                    </h3>
                </div>
                <div class="rounded-3 p-3" style="background:#e8f0f1;color:#173f46;">
                    <i class="bi bi-receipt fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="content-card h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">Menunggu</small>
                    <h3 class="fw-bold mt-2 mb-0">
                        {{ $orders->getCollection()->where('status', 'menunggu')->count() }}
                    </h3>
                </div>
                <div class="rounded-3 p-3" style="background:#fff5df;color:#d49a27;">
                    <i class="bi bi-hourglass-split fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="content-card h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">Diproses</small>
                    <h3 class="fw-bold mt-2 mb-0">
                        {{ $orders->getCollection()->where('status', 'diproses')->count() }}
                    </h3>
                </div>
                <div class="rounded-3 p-3" style="background:#eaf3fb;color:#3576ad;">
                    <i class="bi bi-arrow-repeat fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="content-card h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">Selesai</small>
                    <h3 class="fw-bold mt-2 mb-0">
                        {{ $orders->getCollection()->where('status', 'selesai')->count() }}
                    </h3>
                </div>
                <div class="rounded-3 p-3" style="background:#eaf6ed;color:#398052;">
                    <i class="bi bi-check-circle fs-4"></i>
                </div>
            </div>
        </div>
    </div>

</div>


{{-- TABEL PESANAN --}}
<div class="content-card">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h6 class="fw-bold mb-1">Daftar Seluruh Pesanan</h6>
            <small class="text-muted">
                Informasi pesanan pelanggan yang terdaftar dalam sistem.
            </small>
        </div>

        <div class="text-muted small">
            Total data: {{ $orders->total() }} pesanan
        </div>
    </div>


    {{-- PENCARIAN --}}
    <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-2 mb-4">

        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="bi bi-search"></i>
                </span>

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari ID, nama customer, atau layanan..."
                    value="{{ request('search') }}"
                >
            </div>
        </div>

        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>

        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn-primary-custom">
                <i class="bi bi-funnel me-1"></i>
                Filter
            </button>

            <a href="{{ route('admin.orders.index') }}"
               class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                Reset
            </a>
        </div>

    </form>


    {{-- TABEL --}}
    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Layanan</th>
                    <th>Designer</th>
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

                        <td class="fw-semibold">
                            #{{ $order->id }}
                        </td>

                        <td>
                            <div class="fw-semibold">
                                {{ $order->customer->name ?? $order->customer->nama ?? 'Customer' }}
                            </div>
                            <small class="text-muted">
                                {{ $order->customer->email ?? '-' }}
                            </small>
                        </td>

                        <td>
                            {{ $order->service->nama_jasa ?? $order->service->nama ?? '-' }}
                        </td>

                        <td>
                            {{ $order->designer->name ?? $order->designer->nama ?? 'Belum ditugaskan' }}
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
                            <span class="badge bg-{{ $badgeColor }}-subtle text-{{ $badgeColor }} px-3 py-2">
                                {{ ucfirst($status) }}
                            </span>
                        </td>

                        <td>
                            <div class="d-flex justify-content-center gap-1">

                                {{-- DETAIL --}}
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                   class="btn btn-sm btn-outline-info"
                                   title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>

                                {{-- EDIT --}}
                                <a href="{{ route('admin.orders.edit', $order->id) }}"
                                   class="btn btn-sm btn-outline-warning"
                                   title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                {{-- HAPUS --}}
                                <form action="{{ route('admin.orders.destroy', $order->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </form>

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="text-center py-5">

                            <i class="bi bi-inbox text-muted" style="font-size:45px;"></i>

                            <h6 class="fw-bold mt-3">Belum Ada Pesanan</h6>

                            <p class="text-muted small mb-3">
                                Belum ada data pesanan yang tersedia.
                            </p>

                            <a href="{{ route('admin.orders.create') }}"
                               class="btn-primary-custom">
                                <i class="bi bi-plus-lg me-1"></i>
                                Tambah Pesanan
                            </a>

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
            dari {{ $orders->total() }} data
        </small>

        <div>
            {{ $orders->withQueryString()->links() }}
        </div>

    </div>

</div>

@endsection
