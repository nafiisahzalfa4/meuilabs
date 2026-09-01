<h2>Edit User</h2>

<form action="{{ route('user.update', $user->id) }}" method="POST">

    @csrf
    @method('PUT')

    <label>Nama</label><br>
    <input type="text"
           name="name"
           value="{{ $user->name }}">

    <br><br>

    <label>Email</label><br>
    <input type="email"
           name="email"
           value="{{ $user->email }}">

    <br><br>

    <label>Role</label><br>
    <select name="role">

        <option value="admin"
            {{ $user->role == 'admin' ? 'selected' : '' }}>
            Admin
        </option>

        <option value="customer"
            {{ $user->role == 'customer' ? 'selected' : '' }}>
            Customer
        </option>

        <option value="designer"
            {{ $user->role == 'designer' ? 'selected' : '' }}>
            Designer
        </option>

    </select>

    <br><br>

    <button type="submit">Update</button>

</form>

<br>

<a href="{{ route('user.index') }}">Kembali</a>
