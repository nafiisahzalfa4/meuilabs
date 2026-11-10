@extends('admin.layouts.app')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@section('content')
<div class="row">
    <div class="col-lg-8">

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold mb-1">Detail Pesanan #{{ $order->id }}</h5>
                        <p class="text-muted mb-0">Informasi lengkap pesanan pelanggan.</p>
                    </div>

                    @php
                        $statusClass = [
                            'menunggu' => 'bg-warning text-dark',
                            'diproses' => 'bg-info text-dark',
                            'selesai' => 'bg-success',
                            'dibatalkan' => 'bg-danger',
                        ][$order->status] ?? 'bg-secondary';
                    @endphp

                    <span class="badge {{ $statusClass }} px-3 py-2">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <hr>

                <h6 class="fw-bold mb-3">Informasi Pelanggan</h6>

                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">Nama Pelanggan</div>
                    <div class="col-sm-8 fw-semibold">
                        {{ $order->customer->name ?? $order->customer->nama ?? '-' }}
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-4 text-muted">ID Pelanggan</div>
                    <div class="col-sm-8">{{ $order->customer_id ?? '-' }}</div>
                </div>

                <hr>

                <h6 class="fw-bold mb-3">Informasi Pesanan</h6>

                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Layanan</div>
                    <div class="col-sm-8 fw-semibold">
                        {{ $order->service->nama_jasa ?? $order->service->nama ?? '-' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Desainer</div>
                    <div class="col-sm-8">
                        {{ $order->designer->name ?? $order->designer->nama ?? 'Belum ditentukan' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Tanggal Pesan</div>
                    <div class="col-sm-8">
                        {{ $order->tanggal_pesan ? \Carbon\Carbon::parse($order->tanggal_pesan)->format('d F Y') : '-' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Total Harga</div>
                    <div class="col-sm-8 fw-bold text-success">
                        Rp{{ number_format($order->total_harga ?? 0, 0, ',', '.') }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Catatan</div>
                    <div class="col-sm-8">
                        {{ $order->catatan ?: 'Tidak ada catatan.' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Dibuat Pada</div>
                    <div class="col-sm-8">
                        {{ $order->created_at ? $order->created_at->format('d F Y, H:i') : '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4 text-muted">Terakhir Diperbarui</div>
                    <div class="col-sm-8">
                        {{ $order->updated_at ? $order->updated_at->format('d F Y, H:i') : '-' }}
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-light border">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>

                    <a href="{{ route('admin.orders.edit', $order->id) }}"
                        class="btn btn-warning">
                        <i class="bi bi-pencil-square me-1"></i> Edit Pesanan
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-info-circle text-primary fs-4 me-2"></i>
                    <h6 class="fw-bold mb-0">Informasi Status</h6>
                </div>

                @if($order->status == 'menunggu')
                    <p class="text-muted mb-0">
                        Pesanan sedang menunggu untuk diproses oleh tim desainer.
                    </p>
                @elseif($order->status == 'diproses')
                    <p class="text-muted mb-0">
                        Pesanan sedang dikerjakan oleh tim desainer.
                    </p>
                @elseif($order->status == 'selesai')
                    <p class="text-muted mb-0">
                        Pesanan telah selesai dikerjakan.
                    </p>
                @elseif($order->status == 'dibatalkan')
                    <p class="text-muted mb-0">
                        Pesanan ini telah dibatalkan.
                    </p>
                @else
                    <p class="text-muted mb-0">
                        Status pesanan belum tersedia.
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection