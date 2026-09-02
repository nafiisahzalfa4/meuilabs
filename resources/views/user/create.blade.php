<h2>Tambah User</h2>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">

    @csrf

    <label>Nama</label><br>
    <input type="text" name="name">

    <br><br>

    <label>Email</label><br>
    <input type="email" name="email">

    <br><br>

    <label>Password</label><br>
    <input type="password" name="password">

    <br><br>

    <label>Konfirmasi Password</label><br>
    <input type="password" name="password_confirmation">

    <br><br>

    <label>Role</label><br>
    <select name="role">
        <option value="">-- Pilih Role --</option>
        <option value="admin">Admin</option>
        <option value="customer">Customer</option>
        <option value="designer">Designer</option>
    </select>

    <br><br>

    <label>No. Telepon</label><br>
    <input type="text" name="no_telepon">

    <br><br>

    <label>Alamat</label><br>
    <textarea name="alamat"></textarea>

    <br><br>

    <label>Foto</label><br>
    <input type="file" name="foto">

    <br><br>

    <button type="submit">Simpan</button>

</form>

<br>

<a href="{{ route('user.index') }}">Kembali</a>