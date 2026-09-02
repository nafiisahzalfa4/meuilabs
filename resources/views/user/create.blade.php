<style>
    body {
        font-family: Arial, sans-serif;
        background: #f5f6fa;
        margin: 0;
        padding: 30px;
        color: #333;
    }

    .container {
        max-width: 700px;
        margin: auto;
    }

    .card {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    h2 {
        margin-top: 0;
        margin-bottom: 25px;
        color: #222;
    }

    .form-group {
        margin-bottom: 18px;
    }

    label {
        display: block;
        margin-bottom: 7px;
        font-weight: bold;
        font-size: 14px;
        color: #374151;
    }

    input,
    select,
    textarea {
        width: 100%;
        padding: 11px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
        font-size: 14px;
    }

    textarea {
        min-height: 90px;
        resize: vertical;
    }

    input:focus,
    select:focus,
    textarea:focus {
        outline: none;
        border-color: #4f46e5;
    }

    .error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
        padding: 12px 15px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .error ul {
        margin: 0;
        padding-left: 20px;
    }

    .buttons {
        display: flex;
        gap: 10px;
        margin-top: 25px;
    }

    .btn {
        padding: 11px 18px;
        border-radius: 6px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-simpan {
        background: #4f46e5;
        color: white;
    }

    .btn-simpan:hover {
        background: #4338ca;
    }

    .btn-kembali {
        background: #e5e7eb;
        color: #374151;
    }

    .btn-kembali:hover {
        background: #d1d5db;
    }
</style>

<div class="container">

    <div class="card">

        <h2>Tambah User</h2>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('user.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="form-group">
                <label>Nama</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama"
                >
            </div>

            <div class="form-group">
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email"
                >
            </div>

            <div class="form-group">
                <label>Password</label>
                <input
                    type="password"
                    name="password"
                    placeholder="Masukkan password"
                >
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    placeholder="Masukkan ulang password"
                >
            </div>

            <div class="form-group">
                <label>Role</label>

                <select name="role">
                    <option value="">-- Pilih Role --</option>

                    <option
                        value="admin"
                        {{ old('role') == 'admin' ? 'selected' : '' }}
                    >
                        Admin
                    </option>

                    <option
                        value="customer"
                        {{ old('role') == 'customer' ? 'selected' : '' }}
                    >
                        Customer
                    </option>

                    <option
                        value="designer"
                        {{ old('role') == 'designer' ? 'selected' : '' }}
                    >
                        Designer
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label>No. Telepon</label>

                <input
                    type="text"
                    name="no_telepon"
                    value="{{ old('no_telepon') }}"
                    placeholder="Masukkan nomor telepon"
                >
            </div>

            <div class="form-group">
                <label>Alamat</label>

                <textarea
                    name="alamat"
                    placeholder="Masukkan alamat"
                >{{ old('alamat') }}</textarea>
            </div>

            <div class="form-group">
                <label>Foto</label>

                <input
                    type="file"
                    name="foto"
                >
            </div>

            <div class="buttons">
                <button type="submit" class="btn btn-simpan">
                    Simpan
                </button>

                <a
                    href="{{ route('user.index') }}"
                    class="btn btn-kembali"
                >
                    Kembali
                </a>
            </div>

        </form>

    </div>

</div>