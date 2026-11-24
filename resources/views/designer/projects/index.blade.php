@extends('designer.layouts.app')

@section('title', 'Project Saya')
@section('page-title', 'Project Saya')

@section('content')

<div class="container-fluid">

    {{-- Header Halaman --}}
    <div class="page-heading">
        <h4>Project Saya</h4>
        <p>
            Daftar project dari pesanan yang ditugaskan kepada Anda.
        </p>
    </div>

    {{-- Tabel Project --}}
    <div class="content-card">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Daftar Project</h5>

            <span class="text-muted small">
                Total {{ $projects->total() }} project
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Project</th>
                        <th>Pelanggan</th>
                        <th>Tanggal Mulai</th>
                        <th>Deadline</th>
                        <th>Progress</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($projects as $project)

                        @php
                            $statusLabels = [
                                'not_started' => 'Belum Dimulai',
                                'process' => 'Sedang Dikerjakan',
                                'revision' => 'Revisi',
                                'completed' => 'Selesai',
                            ];

                            $statusColors = [
                                'not_started' => 'secondary',
                                'process' => 'primary',
                                'revision' => 'warning',
                                'completed' => 'success',
                            ];

                            $progress = $project->progress ?? 0;
                        @endphp

                        <tr>

                            {{-- Nomor --}}
                            <td>
                                {{ $projects->firstItem() + $loop->index }}
                            </td>

                            {{-- Nama Project --}}
                            <td>
                                <strong>{{ $project->project_name }}</strong>
                            </td>

                            {{-- Nama Pelanggan --}}
                            <td>
                                {{ optional(optional($project->order)->customer)->name ?? '-' }}
                            </td>

                            {{-- Tanggal Mulai --}}
                            <td>
                                {{ $project->start_date
                                    ? $project->start_date->format('d/m/Y')
                                    : '-' }}
                            </td>

                            {{-- Deadline --}}
                            <td>
                                {{ $project->deadline
                                    ? $project->deadline->format('d/m/Y')
                                    : '-' }}
                            </td>

                            {{-- Progress --}}
                            <td style="min-width: 140px;">

                                <div class="d-flex justify-content-between mb-1">
                                    <small class="fw-semibold">
                                        {{ $progress }}%
                                    </small>
                                </div>

                                <div class="progress" style="height: 8px;">
                                    <div
                                        class="progress-bar"
                                        role="progressbar"
                                        style="width: {{ $progress }}%;"
                                        aria-valuenow="{{ $progress }}"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>
                                </div>

                            </td>

                            {{-- Status --}}
                            <td>
                                <span class="badge bg-{{ $statusColors[$project->status] ?? 'secondary' }}">
                                    {{ $statusLabels[$project->status] ?? $project->status }}
                                </span>
                            </td>

                            {{-- Aksi --}}
                            <td>
                                <a href="{{ route('designer.projects.show', $project->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                    Detail
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center py-5">

                                <i class="bi bi-kanban fs-1 text-muted"></i>

                                <h6 class="text-muted mt-3">
                                    Belum Ada Project
                                </h6>

                                <p class="text-muted small mb-0">
                                    Project yang ditugaskan kepada kamu akan muncul di sini.
                                </p>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

        {{-- Pagination --}}
        @if($projects->hasPages())
            <div class="mt-3">
                {{ $projects->links() }}
            </div>
        @endif

    </div>

</div>

@endsection