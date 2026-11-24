@extends('designer.layouts.app')

@section('content')

<div class="container-fluid">

    {{-- Header Dashboard --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Dashboard Designer</h3>
            <p class="text-muted mb-0">
                Selamat datang, {{ $user->name }}!
            </p>
        </div>

        <a href="{{ route('designer.projects.index') }}"
           class="btn btn-primary">
            <i class="bi bi-kanban"></i> Project Saya
        </a>
    </div>

    {{-- Statistik Pekerjaan --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4 col-lg">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Total Pekerjaan</p>
                    <h3 class="fw-bold">{{ $totalOrders }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Menunggu</p>
                    <h3 class="fw-bold text-warning">{{ $pendingOrders }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Diproses</p>
                    <h3 class="fw-bold text-primary">{{ $processingOrders }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Selesai</p>
                    <h3 class="fw-bold text-success">{{ $completedOrders }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Dibatalkan</p>
                    <h3 class="fw-bold text-danger">{{ $cancelledOrders }}</h3>
                </div>
            </div>
        </div>

    </div>

    {{-- Daftar Pekerjaan Terbaru --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Pekerjaan Terbaru</h5>

                <a href="{{ route('designer.orders.index') }}"
                   class="btn btn-primary btn-sm">
                    Lihat Semua
                </a>
            </div>
        </div>

        <div class="card-body">

            @if($latestOrders->count() > 0)

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Customer</th>
                                <th>Layanan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($latestOrders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        {{ optional($order->customer)->name ?? '-' }}
                                    </td>

                                    <td>
                                        {{ optional($order->service)->nama ?? '-' }}
                                    </td>

                                    <td>
                                        @php
                                            $statusClass = [
                                                'menunggu' => 'warning',
                                                'diproses' => 'primary',
                                                'selesai' => 'success',
                                                'dibatalkan' => 'danger',
                                            ][$order->status] ?? 'secondary';
                                        @endphp

                                        <span class="badge bg-{{ $statusClass }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $order->created_at
                                            ? $order->created_at->format('d/m/Y')
                                            : '-' }}
                                    </td>

                                    <td>
                                        <a href="{{ route('designer.orders.show', $order->id) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @else

                <div class="text-center py-5">
                    <h6 class="text-muted">Belum ada pekerjaan.</h6>
                    <p class="text-muted small mb-0">
                        Pekerjaan yang ditugaskan kepada kamu akan muncul di sini.
                    </p>
                </div>

            @endif

        </div>
    </div>

</div>

@endsection