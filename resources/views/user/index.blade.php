<style>
    body {
        font-family: Arial, sans-serif;
        background: #f5f6fa;
        margin: 0;
        padding: 30px;
        color: #333;
    }

    .container {
        max-width: 1200px;
        margin: auto;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    h2 {
        margin: 0;
        color: #222;
    }

    .btn {
        display: inline-block;
        padding: 10px 16px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        border: none;
        cursor: pointer;
    }

    .btn-tambah {
        background: #4f46e5;
        color: white;
    }

    .btn-tambah:hover {
        background: #4338ca;
    }

    .alert {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 12px 15px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .table-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #f3f4f6;
        color: #374151;
        font-size: 14px;
        padding: 13px 12px;
        text-align: left;
        border-bottom: 2px solid #e5e7eb;
    }

    td {
        padding: 13px 12px;
        border-bottom: 1px solid #e5e7eb;
        font-size: 14px;
    }

    tr:hover {
        background: #f9fafb;
    }

    .foto {
        width: 55px;
        height: 55px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .role {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        background: #eef2ff;
        color: #4338ca;
        font-size: 12px;
        font-weight: bold;
    }

    .btn-edit {
        background: #f59e0b;
        color: white;
    }

    .btn-edit:hover {
        background: #d97706;
    }

    .btn-hapus {
        background: #ef4444;
        color: white;
    }

    .btn-hapus:hover {
        background: #dc2626;
    }

    .aksi {
        display: flex;
        gap: 7px;
        align-items: center;
    }

    .aksi form {
        margin: 0;
    }
</style>

<div class="container">

    <div class="header">
        <h2>Data User</h2>

        <a href="{{ route('user.create') }}" class="btn btn-tambah">
            + Tambah User
        </a>
    </div>

    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-card">

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>No. Telepon</th>
                    <th>Alamat</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $user->name }}</td>

                    <td>{{ $user->email }}</td>

                    <td>
                        <span class="role">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>

                    <td>{{ $user->no_telepon ?? '-' }}</td>

                    <td>{{ $user->alamat ?? '-' }}</td>

                    <td>
                        @if($user->foto)
                            <img
                                src="{{ asset('uploads/users/' . $user->foto) }}"
                                class="foto"
                            >
                        @else
                            -
                        @endif
                    </td>

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
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-hapus"
                                    onclick="return confirm('Yakin ingin menghapus user ini?')"
                                >
                                    Hapus
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</div>