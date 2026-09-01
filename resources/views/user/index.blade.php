<h2>Data User</h2>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<a href="{{ route('user.create') }}">Tambah User</a>

<br><br>

<table border="1">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Role</th>
        <th>Aksi</th>
    </tr>

    @foreach($users as $user)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->role }}</td>
        <td>
            <a href="{{ route('user.edit', $user->id) }}">
                Edit
            </a>

            <form action="{{ route('user.destroy', $user->id) }}"
                  method="POST"
                  style="display:inline">

                @csrf
                @method('DELETE')

                <button type="submit">
                    Hapus
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</table>