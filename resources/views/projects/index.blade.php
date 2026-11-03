
<style>
    * { box-sizing: border-box; }

    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f5f6fa;
        color: #1f2937;
    }

    .page {
        max-width: 1200px;
        margin: 35px auto;
        padding: 0 20px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 24px;
    }

    .page-header h2 {
        margin: 0 0 8px;
        font-size: 26px;
    }

    .page-header p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    .card {
        background: white;
        padding: 24px;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .card-header h3 {
        margin: 0;
        font-size: 17px;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1000px;
    }

    th {
        padding: 14px 12px;
        background: #f9fafb;
        color: #6b7280;
        font-size: 12px;
        font-weight: 700;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }

    td {
        padding: 15px 12px;
        font-size: 13px;
        border-bottom: 1px solid #f1f2f4;
        vertical-align: middle;
    }

    tbody tr:hover { background: #fafafa; }

    .project-name {
        font-weight: 600;
        color: #1f2937;
    }

    .sub-text {
        display: block;
        margin-top: 5px;
        color: #9ca3af;
        font-size: 12px;
    }

    .badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-not-started {
        background: #f3f4f6;
        color: #4b5563;
    }

    .status-process {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-revision {
        background: #fef3c7;
        color: #92400e;
    }

    .status-completed {
        background: #dcfce7;
        color: #166534;
    }

    .progress-wrapper {
        width: 110px;
    }

    .progress-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 6px;
        font-size: 11px;
        font-weight: 600;
    }

    .progress-bar {
        width: 100%;
        height: 7px;
        background: #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: #6d5dfc;
        border-radius: 10px;
    }

    .actions {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 11px;
        border: 0;
        border-radius: 7px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-primary {
        background: #6d5dfc;
        color: white;
    }

    .btn-detail {
        background: #e0f2fe;
        color: #0369a1;
    }

    .btn-edit {
        background: #fef3c7;
        color: #92400e;
    }

    .btn-delete {
        background: #fee2e2;
        color: #b91c1c;
    }

    .alert-success {
        margin-bottom: 20px;
        padding: 13px 16px;
        color: #166534;
        background: #dcfce7;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        font-size: 14px;
    }

    .empty {
        padding: 45px 15px;
        text-align: center;
        color: #9ca3af;
        font-size: 14px;
    }

    .empty strong {
        display: block;
        color: #374151;
        font-size: 16px;
        margin-bottom: 7px;
    }

    @media (max-width: 600px) {
        .page {
            margin: 20px auto;
            padding: 0 12px;
        }

        .page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .card { padding: 16px; }
    }
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h2>Kelola Proyek</h2>
            <p>Pantau dan kelola seluruh proyek pelanggan MeUI Labs.</p>
        </div>

        <a href="{{ route('projects.create') }}" class="btn btn-primary">
            + Tambah Proyek
        </a>
    </div>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        <div class="card-header">
            <h3>Daftar Proyek</h3>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Proyek</th>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Tanggal Mulai</th>
                        <th>Deadline</th>
                        <th>Progress</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($projects as $project)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <span class="project-name">
                                    {{ $project->project_name }}
                                </span>
                                <span class="sub-text">
                                    Pesanan #{{ $project->order_id }}
                                </span>
                            </td>

                            <td>
                                {{ $project->order->customer->name ?? '-' }}
                            </td>

                            <td>
                                {{ $project->order->service->nama_jasa ?? '-' }}
                            </td>

                            <td>
                                {{ $project->start_date
                                    ? $project->start_date->format('d/m/Y')
                                    : '-' }}
                            </td>

                            <td>
                                {{ $project->deadline
                                    ? $project->deadline->format('d/m/Y')
                                    : '-' }}
                            </td>

                            <td>
                                <div class="progress-wrapper">
                                    <div class="progress-info">
                                        <span>Progress</span>
                                        <span>{{ $project->progress ?? 0 }}%</span>
                                    </div>

                                    <div class="progress-bar">
                                        <div class="progress-fill"
                                             style="width: {{ min(100, max(0, $project->progress ?? 0)) }}%">
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                @if ($project->status == 'not_started')
                                    <span class="badge status-not-started">
                                        Belum Dimulai
                                    </span>
                                @elseif ($project->status == 'process')
                                    <span class="badge status-process">
                                        Diproses
                                    </span>
                                @elseif ($project->status == 'revision')
                                    <span class="badge status-revision">
                                        Revisi
                                    </span>
                                @elseif ($project->status == 'completed')
                                    <span class="badge status-completed">
                                        Selesai
                                    </span>
                                @else
                                    <span class="badge status-not-started">
                                        -
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="actions">

                                    <a href="{{ route('projects.show', $project->id) }}"
                                       class="btn btn-detail">
                                        Detail
                                    </a>

                                    <a href="{{ route('projects.edit', $project->id) }}"
                                       class="btn btn-edit">
                                        Edit
                                    </a>

                                    <form action="{{ route('projects.destroy', $project->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus proyek ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-delete">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty">
                                    <strong>Belum Ada Proyek</strong>
                                    Belum ada proyek yang ditambahkan.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
