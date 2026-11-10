@extends('admin.layouts.app')

@section('title', 'Edit Pesanan')
@section('page-title', 'Edit Pesanan')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <div class="mb-4">
            <h5 class="fw-bold mb-1">Form Edit Pesanan</h5>
            <p class="text-muted mb-0">
                Perbarui informasi pesanan #{{ $order->id }}.
            </p>
        </div>

        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="customer_id" class="form-label fw-semibold">
                        Pelanggan <span class="text-danger">*</span>
                    </label>
                    <select name="customer_id" id="customer_id"
                        class="form-select @error('customer_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}"
                                {{ old('customer_id', $order->customer_id) == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name ?? $customer->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="designer_id" class="form-label fw-semibold">Desainer</label>
                    <select name="designer_id" id="designer_id"
                        class="form-select @error('designer_id') is-invalid @enderror">
                        <option value="">-- Belum Ditentukan --</option>
                        @foreach($designers as $designer)
                            <option value="{{ $designer->id }}"
                                {{ old('designer_id', $order->designer_id) == $designer->id ? 'selected' : '' }}>
                                {{ $designer->name ?? $designer->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('designer_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="service_id" class="form-label fw-semibold">
                        Layanan <span class="text-danger">*</span>
                    </label>
                    <select name="service_id" id="service_id"
                        class="form-select @error('service_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Layanan --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}"
                                data-harga="{{ $service->harga }}"
                                {{ old('service_id', $order->service_id) == $service->id ? 'selected' : '' }}>
                                {{ $service->nama_jasa ?? $service->nama }}
                                - Rp{{ number_format($service->harga, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tanggal_pesan" class="form-label fw-semibold">
                        Tanggal Pesan <span class="text-danger">*</span>
                    </label>
                    <input type="date" name="tanggal_pesan" id="tanggal_pesan"
                        class="form-control @error('tanggal_pesan') is-invalid @enderror"
                        value="{{ old('tanggal_pesan', $order->tanggal_pesan ? \Carbon\Carbon::parse($order->tanggal_pesan)->format('Y-m-d') : '') }}"
                        required>
                    @error('tanggal_pesan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="total_harga" class="form-label fw-semibold">
                        Total Harga (Rp) <span class="text-danger">*</span>
                    </label>
                    <input type="number" name="total_harga" id="total_harga"
                        class="form-control @error('total_harga') is-invalid @enderror"
                        value="{{ old('total_harga', $order->total_harga) }}"
                        min="0" required>
                    @error('total_harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label fw-semibold">Status Pesanan</label>
                    <select name="status" id="status" class="form-select">
                        <option value="menunggu" {{ old('status', $order->status) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diproses" {{ old('status', $order->status) == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ old('status', $order->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ old('status', $order->status) == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label for="catatan" class="form-label fw-semibold">Catatan Pesanan</label>
                    <textarea name="catatan" id="catatan" rows="4"
                        class="form-control @error('catatan') is-invalid @enderror"
                        placeholder="Masukkan catatan tambahan...">{{ old('catatan', $order->catatan) }}</textarea>
                    @error('catatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('admin.orders.show', $order->id) }}"
                    class="btn btn-light border">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const serviceSelect = document.getElementById('service_id');
    const priceInput = document.getElementById('total_harga');

    serviceSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const price = selectedOption.getAttribute('data-harga');

        if (price !== null && price !== '') {
            priceInput.value = price;
        }
    });
</script>
@endpush