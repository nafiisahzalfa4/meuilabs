@extends('designer.layouts.app')

@section('title', 'Detail Pekerjaan')
@section('page-title', 'Detail Pekerjaan')

@section('content')

<div class="page-heading d-flex justify-content-between align-items-center flex-wrap gap-2">

    <div>
        <h4>Detail Pekerjaan #{{ $order->id }}</h4>
        <p>Informasi lengkap pesanan yang ditugaskan kepada kamu.</p>
    </div>

    <a href="{{ route('designer.orders.index') }}"
       class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>
        Kembali
    </a>

</div>


<div class="row g-4">

    {{-- INFORMASI PESANAN --}}
    <div class="col-lg-8">

        <div class="content-card mb-4">

            <h6 class="fw-bold mb-4">Informasi Pesanan</h6>

            <div class="row mb-3">
                <div class="col-sm-4 text-muted small">ID Pesanan</div>
                <div class="col-sm-8 fw-semibold">#{{ $order->id }}</div>
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-sm-4 text-muted small">Nama Customer</div>
                <div class="col-sm-8">
                    {{ optional($order->customer)->name ?? '-' }}
                </div>
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-sm-4 text-muted small">Email Customer</div>
                <div class="col-sm-8">
                    {{ optional($order->customer)->email ?? '-' }}
                </div>
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-sm-4 text-muted small">Layanan</div>
                <div class="col-sm-8">
                    {{ optional($order->service)->nama_jasa
                        ?? optional($order->service)->nama
                        ?? '-' }}
                </div>
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-sm-4 text-muted small">Tanggal Pesan</div>
                <div class="col-sm-8">
                    {{ $order->tanggal_pesan
                        ? \Carbon\Carbon::parse($order->tanggal_pesan)->format('d F Y')
                        : '-' }}
                </div>
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-sm-4 text-muted small">Total Harga</div>
                <div class="col-sm-8 fw-bold">
                    Rp{{ number_format($order->total_harga ?? 0, 0, ',', '.') }}
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-sm-4 text-muted small">Catatan</div>
                <div class="col-sm-8">
                    {{ $order->catatan ?: 'Tidak ada catatan.' }}
                </div>
            </div>

        </div>


        {{-- INFORMASI PROJECT --}}
        @if($order->project)

            <div class="content-card">

                <h6 class="fw-bold mb-3">Informasi Project</h6>

                <div class="mb-3">
                    <small class="text-muted">Nama Project</small>
                    <div class="fw-semibold">
                        {{ $order->project->project_name ?? '-' }}
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Tanggal Mulai</small>
                        <div>
                            {{ $order->project->start_date
                                ? \Carbon\Carbon::parse($order->project->start_date)->format('d/m/Y')
                                : '-' }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Deadline</small>
                        <div>
                            {{ $order->project->deadline
                                ? \Carbon\Carbon::parse($order->project->deadline)->format('d/m/Y')
                                : '-' }}
                        </div>
                    </div>

                </div>

                <small class="text-muted">Progress</small>

                <div class="progress mt-2" style="height:10px;">
                    <div class="progress-bar"
                         role="progressbar"
                         style="width: {{ min(100, max(0, $order->project->progress ?? 0)) }}%;">
                    </div>
                </div>

                <small class="text-muted">
                    {{ $order->project->progress ?? 0 }}%
                </small>

            </div>

        @endif

    </div>


    {{-- STATUS PEKERJAAN --}}
    <div class="col-lg-4">

        <div class="content-card">

            <h6 class="fw-bold mb-3">Status Pekerjaan</h6>

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

            <div class="mb-4">
                <span class="badge bg-{{ $badgeColor }} px-3 py-2">
                    {{ ucfirst($status) }}
                </span>
            </div>

            @if(!in_array($status, ['selesai', 'dibatalkan']))

                <form action="{{ route('designer.orders.updateStatus', $order->id) }}"
                      method="POST">

                    @csrf
                    @method('PATCH')

                    <label for="status" class="form-label">
                        Ubah Status
                    </label>

                    <select name="status" id="status" class="form-select mb-3" required>

                        <option value="diproses"
                            {{ $status == 'diproses' ? 'selected' : '' }}>
                            Diproses
                        </option>

                        <option value="selesai">
                            Selesai
                        </option>

                    </select>

                    <button type="submit" class="btn-primary-custom w-100">
                        <i class="bi bi-check-circle me-1"></i>
                        Simpan Status
                    </button>

                </form>

            @else

                <p class="text-muted small mb-0">
                    Status pekerjaan ini sudah tidak dapat diubah.
                </p>

            @endif

        </div>

    </div>

</div>

@endsection