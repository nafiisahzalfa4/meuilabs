@extends('customer.layouts.app')

@section('title', 'Pesanan Saya')
@section('page-title', 'Pesanan Saya')

@push('styles')
<style>
    .page-heading {
        margin-bottom: 25px;
    }

    .orders-card {
        background: white;
        border: 1px solid #edf0f1;
        border-radius: 12px;
        padding: 22px;
        box-shadow: 0 3px 12px rgba(0,0,0,.025);
    }

    .orders-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .orders-header h5 {
        font-size: 16px;
        font-weight: 700;
        margin: 0;
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

    .action-buttons {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .btn-small {
        padding: 7px 11px;
        font-size: 11px;
    }

    .btn-danger-custom {
        background: #c94d4d;
        color: white;
        border: none;
        border-radius: 7px;
        padding: 7px 11px;
        font-size: 11px;
    }

    .btn-danger-custom:hover {
        background: #a83b3b;
    }

    .empty-state {
        text-align: center;
        padding: 45px 15px;
        color: #839096;
    }

    .empty-state i {
        font-size: 38px;
        margin-bottom: 12px;
    }

    .empty-state h5 {
        color: #263238;
    }
</style>
@endpush

@section('content')

<div class="page-heading">
    <h4>Pesanan Saya</h4>
    <p>Kelola dan pantau pesanan desainmu di MeUI Labs.</p>
</div>

<div class="orders-card">

    <div class="orders-header">
        <h5>Daftar Pesanan</h5>

        <a href="{{ route('customer.orders.create') }}"
           class="btn-primary-custom">
            <i class="bi bi-plus-circle"></i>
            Buat Pesanan
        </a>
    </div>

    @if($orders->count() > 0)

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Pesanan</th>
                        <th>Layanan</th>
                        <th>Designer</th>
                        <th>Tanggal Pesan</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $orders->firstItem() + $loop->index }}</td>

                            <td>#{{ $order->id }}</td>

                            <td>{{ $order->service->nama_jasa ?? '-' }}</td>

                            <td>{{ $order->designer->name ?? 'Belum ditentukan' }}</td>

                            <td>
                                {{ $order->tanggal_pesan
                                    ? \Carbon\Carbon::parse($order->tanggal_pesan)->format('d-m-Y')
                                    : '-' }}
                            </td>

                            <td>
                                Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}
                            </td>

                            <td>
                                <span class="status {{ strtolower($order->status) }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>

                            <td>
                                <div class="action-buttons">

                                    <a href="{{ route('customer.orders.show', $order->id) }}"
                                       class="btn-primary-custom btn-small">
                                        Detail
                                    </a>

                                    @if($order->status === 'menunggu')

                                        <a href="{{ route('customer.orders.edit', $order->id) }}"
                                           class="btn btn-warning btn-small">
                                            Edit
                                        </a>

                                        <form action="{{ route('customer.orders.destroy', $order->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn-danger-custom">
                                                Batalkan
                                            </button>
                                        </form>

                                    @endif

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $orders->links() }}
        </div>

    @else

        <div class="empty-state">
            <i class="bi bi-inbox d-block"></i>
            <h5>Belum Ada Pesanan</h5>
            <p>Kamu belum memiliki pesanan desain.</p>

            <a href="{{ route('customer.orders.create') }}"
               class="btn-primary-custom">
                Buat Pesanan Sekarang
            </a>
        </div>

    @endif

</div>

@endsection
