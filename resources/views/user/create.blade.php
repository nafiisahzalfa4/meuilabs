<h2>Tambah User</h2>

<form action="{{ route('user.store') }}" method="POST">

    @csrf

    <label>Nama</label><br>
    <input type="text" name="name">

    <br><br>

    <label>Email</label><br>
    <input type="email" name="email">

    <br><br>

    <label>Role</label><br>
    <select name="role">
        <option value="">-- Pilih Role --</option>
        <option value="admin">Admin</option>
        <option value="customer">Customer</option>
        <option value="designer">Designer</option>
    </select>

    <br><br>

    <button type="submit">Simpan</button>

</form>

<br>

<a href="{{ route('user.index') }}">Kembali</a>