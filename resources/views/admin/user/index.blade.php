@extends('admin.layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Manajemen Pengguna</h4>
            <p class="text-muted mb-0">Kelola akun admin, customer, dan designer MeUI Labs.</p>
        </div>

        <a href="{{ route('admin.user.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i> Tambah User
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-1">Daftar Pengguna</h5>
            <small class="text-muted">Total {{ $users->count() }} pengguna</small>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Pengguna</th>
                            <th>Role</th>
                            <th>No. Telepon</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if($user->foto && file_exists(public_path('uploads/users/' . $user->foto)))
                                        <img src="{{ asset('uploads/users/' . $user->foto) }}"
                                             alt="Foto {{ $user->name }}"
                                             class="rounded-circle"
                                             style="width:42px;height:42px;object-fit:cover;">
                                    @else
                                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                             style="width:42px;height:42px;background:#e4eff0;color:#173f46;">
                                            {{ strtoupper(substr($user->name ?: '?', 0, 1)) }}
                                        </div>
                                    @endif

                                    <div>
                                        <div class="fw-semibold">{{ $user->name }}</div>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                @php
                                    $roleColors = [
                                        'admin' => 'primary',
                                        'customer' => 'info',
                                        'designer' => 'success'
                                    ];
                                @endphp

                                <span class="badge bg-{{ $roleColors[$user->role] ?? 'secondary' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>

                            <td>{{ $user->no_telepon ?: '-' }}</td>
                            <td>{{ $user->alamat ?: '-' }}</td>

                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.user.edit', $user->id) }}"
                                       class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('admin.user.destroy', $user->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus akun {{ $user->name }}?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-people text-muted fs-1"></i>
                                <p class="fw-semibold mt-2 mb-1">Belum ada pengguna</p>
                                <small class="text-muted">Silakan tambahkan akun pengguna baru.</small>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection