@extends('designer.layouts.app')

@section('title', 'Detail Project')

@section('content')
<div class="container-fluid">

    <div class="page-heading mb-4">
        <h3>Detail Project</h3>
        <p class="text-muted">
            Lihat informasi dan perbarui progress project Anda.
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="content-card mb-4">
        <h5 class="mb-3">Informasi Project</h5>

        <div class="row mb-3">
            <div class="col-md-4 text-muted">Nama Project</div>
            <div class="col-md-8 fw-bold">
                {{ $project->project_name }}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 text-muted">Nama Pelanggan</div>
            <div class="col-md-8">
                {{ optional(optional($project->order)->customer)->name ?? '-' }}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 text-muted">Layanan</div>
            <div class="col-md-8">
                {{ optional(optional($project->order)->service)->name ?? '-' }}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 text-muted">Tanggal Mulai</div>
            <div class="col-md-8">
                {{ optional($project->start_date)->format('d/m/Y') ?? '-' }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 text-muted">Deadline</div>
            <div class="col-md-8">
                {{ optional($project->deadline)->format('d/m/Y') ?? '-' }}
            </div>
        </div>
    </div>

    <div class="content-card">
        <h5 class="mb-3">Perbarui Progress Project</h5>

        <form action="{{ route('designer.projects.update', $project->id) }}"
              method="POST">

            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="progress" class="form-label">
                    Progress (0–100%)
                </label>

                <input
                    type="number"
                    name="progress"
                    id="progress"
                    class="form-control"
                    min="0"
                    max="100"
                    value="{{ old('progress', $project->progress) }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">
                    Status Project
                </label>

                <select name="status" id="status" class="form-select" required>
                    <option value="not_started"
                        {{ old('status', $project->status) == 'not_started' ? 'selected' : '' }}>
                        Belum Dimulai
                    </option>

                    <option value="process"
                        {{ old('status', $project->status) == 'process' ? 'selected' : '' }}>
                        Sedang Dikerjakan
                    </option>

                    <option value="revision"
                        {{ old('status', $project->status) == 'revision' ? 'selected' : '' }}>
                        Revisi
                    </option>

                    <option value="completed"
                        {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>
                        Selesai
                    </option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Progress
                </button>

                <a href="{{ route('designer.projects.index') }}"
                   class="btn btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>

</div>
@endsection