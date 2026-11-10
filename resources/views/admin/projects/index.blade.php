
@extends('admin.layouts.app')

@section('title', 'Data Projects')
@section('page-title', 'Manajemen Projects')

@section('content')

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Daftar Projects</h4>
        <p class="text-muted mb-0">Kelola proyek dari pesanan pelanggan.</p>
    </div>

    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-plus-lg me-1"></i> Tambah Project
    </a>
</div>

{{-- Statistik --}}
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <small class="text-muted">Total Projects</small>
                <h3 class="fw-bold mb-0">{{ $projects->total() }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <small class="text-muted">Belum Dimulai</small>
                <h3 class="fw-bold text-secondary mb-0">
                    {{ \App\Project::where('status', 'not_started')->count() }}
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <small class="text-muted">Sedang Dikerjakan</small>
                <h3 class="fw-bold text-primary mb-0">
                    {{ \App\Project::where('status', 'process')->count() }}
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <small class="text-muted">Selesai</small>
                <h3 class="fw-bold text-success mb-0">
                    {{ \App\Project::where('status', 'completed')->count() }}
                </h3>
            </div>
        </div>
    </div>
</div>

{{-- Tabel Projects --}}
<div class="card border-0 shadow-sm">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
            <h5 class="fw-bold mb-0">Data Proyek</h5>

            <form action="{{ route('admin.projects.index') }}" method="GET" class="d-flex gap-2">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari nama proyek..."
                    value="{{ request('search') }}"
                >

                <button type="submit" class="btn btn-outline-secondary">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Nama Project</th>
                        <th>Pesanan</th>
                        <th>Tanggal Mulai</th>
                        <th>Deadline</th>
                        <th>Progress</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($projects as $index => $project)
                        <tr>
                            <td>{{ $projects->firstItem() + $index }}</td>

                            <td>
                                <div class="fw-semibold">{{ $project->project_name }}</div>
                                <small class="text-muted">
                                    Project #{{ $project->id }}
                                </small>
                            </td>

                            <td>
                                <div class="fw-semibold">
                                    #{{ $project->order_id }}
                                </div>
                                <small class="text-muted">
                                    {{ optional(optional($project->order)->customer)->name
                                        ?? optional(optional($project->order)->customer)->nama
                                        ?? 'Pelanggan tidak tersedia' }}
                                </small>
                            </td>

                            <td>
                                {{ $project->start_date
                                    ? \Carbon\Carbon::parse($project->start_date)->format('d M Y')
                                    : '-' }}
                            </td>

                            <td>
                                {{ $project->deadline
                                    ? \Carbon\Carbon::parse($project->deadline)->format('d M Y')
                                    : '-' }}
                            </td>

                            <td style="min-width: 130px;">
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="fw-semibold">{{ $project->progress }}%</small>
                                </div>
                                <div class="progress" style="height: 7px;">
                                    <div
                                        class="progress-bar"
                                        role="progressbar"
                                        style="width: {{ $project->progress }}%;"
                                        aria-valuenow="{{ $project->progress }}"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>
                                </div>
                            </td>

                            <td>
                                @if($project->status == 'not_started')
                                    <span class="badge bg-secondary">Belum Dimulai</span>
                                @elseif($project->status == 'process')
                                    <span class="badge bg-primary">Diproses</span>
                                @elseif($project->status == 'revision')
                                    <span class="badge bg-warning text-dark">Revisi</span>
                                @elseif($project->status == 'completed')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-light text-dark">{{ $project->status }}</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a
                                        href="{{ route('admin.projects.show', $project->id) }}"
                                        class="btn btn-sm btn-outline-info"
                                        title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a
                                        href="{{ route('admin.projects.edit', $project->id) }}"
                                        class="btn btn-sm btn-outline-warning"
                                        title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form
                                        action="{{ route('admin.projects.destroy', $project->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus project ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bi bi-folder2-open fs-1 text-muted"></i>
                                <p class="text-muted mt-2 mb-0">Belum ada data project.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $projects->withQueryString()->links() }}
        </div>

    </div>
</div>

@endsection
