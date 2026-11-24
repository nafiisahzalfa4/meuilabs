
@extends('customer.layouts.app')

@section('title', 'Edit Pesanan')
@section('page-title', 'Edit Pesanan')

@push('styles')
<style>
    .form-card {
        background: white;
        border: 1px solid #edf0f1;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 3px 12px rgba(0,0,0,.025);
        max-width: 850px;
    }

    .form-heading {
        margin-bottom: 25px;
    }

    .form-heading h5 {
        font-weight: 700;
        font-size: 17px;
    }

    .form-heading p {
        color: #839096;
        font-size: 12px;
    }

    .form-label {
        font-size: 12px;
        font-weight: 600;
    }

    .form-control,
    .form-select {
        font-size: 13px;
        padding: 11px 12px;
        border-radius: 7px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 25px;
    }

    .order-info {
        background: #f4f7f8;
        border-radius: 8px;
        padding: 13px 15px;
        margin-bottom: 22px;
        font-size: 12px;
    }
</style>
@endpush

@section('content')

<div class="page-heading">
    <h4>Edit Pesanan</h4>
    <p>Perbarui informasi pesanan desainmu.</p>
</div>

<div class="form-card">

    <div class="form-heading">
        <h5>Formulir Edit Pesanan</h5>
        <p>Ubah informasi pesanan sesuai kebutuhanmu.</p>
    </div>

    <div class="order-info">
        <strong>ID Pesanan:</strong> #{{ $order->id }}
        <br>
        <strong>Status:</strong> {{ ucfirst($order->status) }}
    </div>

    <form action="{{ route('customer.orders.update', $order->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="service_id" class="form-label">Pilih Layanan</label>

            <select name="service_id" id="service_id"
                    class="form-select @error('service_id') is-invalid @enderror"
                    required>

                <option value="">-- Pilih Layanan --</option>

                @foreach($services as $service)
                    <option value="{{ $service->id }}"
                        {{ old('service_id', $order->service_id) == $service->id ? 'selected' : '' }}>
                        {{ $service->nama_jasa }}
                        - Rp {{ number_format($service->harga, 0, ',', '.') }}
                    </option>
                @endforeach

            </select>

            @error('service_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tanggal_pesan" class="form-label">Tanggal Pemesanan</label>

            <input type="date"
                   name="tanggal_pesan"
                   id="tanggal_pesan"
                   class="form-control @error('tanggal_pesan') is-invalid @enderror"
                   value="{{ old('tanggal_pesan', $order->tanggal_pesan) }}"
                   required>

            @error('tanggal_pesan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan Pesanan</label>

            <textarea name="catatan"
                      id="catatan"
                      rows="5"
                      class="form-control @error('catatan') is-invalid @enderror"
                      placeholder="Jelaskan kebutuhan desainmu...">{{ old('catatan', $order->catatan) }}</textarea>

            @error('catatan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('customer.orders.index') }}"
               class="btn btn-light">
                Batal
            </a>

            <button type="submit" class="btn-primary-custom">
                <i class="bi bi-save"></i>
                Simpan Perubahan
            </button>
        </div>

    </form>

</div>

@endsection
