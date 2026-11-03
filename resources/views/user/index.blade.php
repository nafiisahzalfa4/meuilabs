<style>
    * { box-sizing: border-box; }

    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f5f6fa;
        color: #1f2937;
    }

    .page { max-width: 1250px; margin: 35px auto; padding: 0 20px; }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 25px;
    }

    .page-header h2 { margin: 0 0 8px; font-size: 26px; }
    .page-header p { margin: 0; color: #6b7280; font-size: 14px; }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 15px;
        border: 0;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-primary { background: #6d5dfc; color: #fff; }
    .btn-primary:hover { background: #5948ed; }
    .btn-edit { background: #fff7ed; color: #c2410c; }
    .btn-edit:hover { background: #ffedd5; }
    .btn-delete { background: #fef2f2; color: #b91c1c; }
    .btn-delete:hover { background: #fee2e2; }

    .alert {
        margin-bottom: 20px;
        padding: 14px 16px;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
        border-radius: 9px;
        font-size: 14px;
    }

    .table-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
        overflow: hidden;
    }

    .table-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 22px;
        border-bottom: 1px solid #e5e7eb;
    }

    .table-heading h3 { margin: 0; font-size: 16px; }
    .table-heading span { color: #6b7280; font-size: 13px; }

    .table-scroll { overflow-x: auto; }

    table {
        width: 100%;
        min-width: 950px;
        border-collapse: collapse;
    }

    th {
        padding: 14px 16px;
        background: #f9fafb;
        color: #6b7280;
        text-align: left;
        text-transform: uppercase;
        letter-spacing: .04em;
        font-size: 11px;
        font-weight: 700;
    }

    td {
        padding: 15px 16px;
        border-top: 1px solid #f0f1f4;
        font-size: 13px;
        vertical-align: middle;
    }

    tbody tr:hover { background: #fafaff; }

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 190px;
    }

    .avatar {
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #ede9fe;
        color: #5b21b6;
        font-size: 16px;
        font-weight: 700;
        object-fit: cover;
    }

    .user-name { font-weight: 600; color: #111827; }
    .user-email { margin-top: 4px; color: #6b7280; font-size: 12px; }

    .role {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }

    .role-admin { background: #ede9fe; color: #6d28d9; }
    .role-customer { background: #dbeafe; color: #1d4ed8; }
    .role-designer { background: #d1fae5; color: #047857; }

    .aksi { display: flex; align-items: center; gap: 7px; }
    .aksi form { margin: 0; }

    .empty {
        padding: 50px 20px;
        text-align: center;
        color: #6b7280;
    }

    .empty strong {
        display: block;
        margin-bottom: 8px;
        color: #374151;
        font-size: 16px;
    }

    .empty p { margin: 0 0 18px; font-size: 13px; }

    @media (max-width: 600px) {
        .page { margin: 22px auto; padding: 0 12px; }
        .page-header { align-items: flex-start; flex-direction: column; }
        .table-heading { align-items: flex-start; flex-direction: column; gap: 8px; }
    }
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h2>Manajemen User</h2>
            <p>Kelola akun admin, customer, dan designer MeUI Labs.</p>
        </div>

        <a href="{{ route('user.create') }}" class="btn btn-primary">
            + Tambah User
        </a>
    </div>

    @if (session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-card">
        <div class="table-heading">
            <h3>Daftar Pengguna</h3>
            <span>Total {{ $users->count() }} user</span>
        </div>

        <div class="table-scroll">
            @if ($users->isNotEmpty())
                <table>
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
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <div class="user-info">
                                        @if ($user->foto && file_exists(public_path('uploads/users/' . $user->foto)))
                                            <img
                                                src="{{ asset('uploads/users/' . $user->foto) }}"
                                                alt="Foto {{ $user->name }}"
                                                class="avatar"
                                            >
                                        @else
                                            <div class="avatar">
                                                {{ strtoupper(substr($user->name ?: '?', 0, 1)) }}
                                            </div>
                                        @endif

                                        <div>
                                            <div class="user-name">{{ $user->name }}</div>
                                            <div class="user-email">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="role role-{{ $user->role }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>

                                <td>{{ $user->no_telepon ?: '-' }}</td>

                                <td>{{ $user->alamat ?: '-' }}</td>

                                <td>
                                    <div class="aksi">
                                        <a
                                            href="{{ route('user.edit', $user->id) }}"
                                            class="btn btn-edit"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('user.destroy', $user->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus akun {{ $user->name }}?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-delete">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty">
                    <strong>Belum ada pengguna</strong>
                    <p>Tambahkan akun pertama untuk mulai mengelola pengguna MeUI Labs.</p>
                    <a href="{{ route('user.create') }}" class="btn btn-primary">
                        Tambah User
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>