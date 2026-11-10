
@extends('admin.layouts.app')

@section('title', 'Tambah Project')
@section('page-title', 'Tambah Project')

@section('content')

<div class="mb-4">
    <a href="{{ route('admin.projects.index') }}" class="text-decoration-none text-muted">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Projects
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="fw-bold mb-1">Tambah Project Baru</h5>
        <small class="text-muted">Lengkapi informasi proyek yang akan dikelola.</small>
    </div>

    <div class="card-body p-4">

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Periksa kembali input kamu:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.projects.store') }}" method="POST">
            @csrf

            <div class="row g-3">

                <div class="col-md-12">
                    <label for="order_id" class="form-label fw-semibold">
                        Pesanan <span class="text-danger">*</span>
                    </label>

                    <select name="order_id" id="order_id" class="form-select @error('order_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Pesanan --</option>

                        @foreach($orders as $order)
                            <option value="{{ $order->id }}" {{ old('order_id') == $order->id ? 'selected' : '' }}>
                                Pesanan #{{ $order->id }}
                                -
                                {{ optional($order->customer)->name ?? optional($order->customer)->nama ?? 'Pelanggan' }}
                                -
                                {{ optional($order->service)->nama_jasa ?? optional($order->service)->nama ?? 'Layanan' }}
                            </option>
                        @endforeach
                    </select>

                    @error('order_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <small class="text-muted">Pilih pesanan yang belum memiliki proyek.</small>
                </div>

                <div class="col-md-12">
                    <label for="project_name" class="form-label fw-semibold">
                        Nama Project <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="project_name"
                        id="project_name"
                        class="form-control @error('project_name') is-invalid @enderror"
                        value="{{ old('project_name') }}"
                        placeholder="Contoh: Website Company Profile"
                        maxlength="100"
                        required
                    >

                    @error('project_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="start_date" class="form-label fw-semibold">Tanggal Mulai</label>

                    <input
                        type="date"
                        name="start_date"
                        id="start_date"
                        class="form-control @error('start_date') is-invalid @enderror"
                        value="{{ old('start_date') }}"
                    >

                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="deadline" class="form-label fw-semibold">Deadline</label>

                    <input
                        type="date"
                        name="deadline"
                        id="deadline"
                        class="form-control @error('deadline') is-invalid @enderror"
                        value="{{ old('deadline') }}"
                    >

                    @error('deadline')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="progress" class="form-label fw-semibold">Progress (%)</label>

                    <input
                        type="number"
                        name="progress"
                        id="progress"
                        class="form-control @error('progress') is-invalid @enderror"
                        value="{{ old('progress', 0) }}"
                        min="0"
                        max="100"
                        placeholder="0 - 100"
                    >

                    @error('progress')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label fw-semibold">
                        Status Project <span class="text-danger">*</span>
                    </label>

                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="not_started" {{ old('status', 'not_started') == 'not_started' ? 'selected' : '' }}>
                            Belum Dimulai
                        </option>
                        <option value="process" {{ old('status') == 'process' ? 'selected' : '' }}>
                            Diproses
                        </option>
                        <option value="revision" {{ old('status') == 'revision' ? 'selected' : '' }}>
                            Revisi
                        </option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                            Selesai
                        </option>
                    </select>

                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.projects.index') }}" class="btn btn-light border">
                    Batal
                </a>

                <button type="submit" class="btn btn-primary-custom">
                    <i class="bi bi-save me-1"></i> Simpan Project
                </button>
            </div>

        </form>
    </div>
</div>

@endsection
