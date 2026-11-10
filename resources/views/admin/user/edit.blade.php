<style>
    * { box-sizing: border-box; }

    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f5f6fa;
        color: #1f2937;
    }

    .page { max-width: 850px; margin: 35px auto; padding: 0 20px; }
    .page-header { margin-bottom: 22px; }
    .page-header h2 { margin: 0 0 8px; font-size: 26px; }
    .page-header p { margin: 0; color: #6b7280; font-size: 14px; }

    .card {
        background: #fff;
        padding: 28px;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
    }

    .section-title {
        margin: 0 0 22px;
        padding-bottom: 14px;
        border-bottom: 1px solid #e5e7eb;
        font-size: 17px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .form-group { margin-bottom: 20px; }
    .form-group.full { grid-column: 1 / -1; }

    label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 600;
    }

    input, select, textarea {
        width: 100%;
        padding: 12px 13px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #fff;
        color: #1f2937;
        font: inherit;
        font-size: 14px;
    }

    textarea { min-height: 100px; resize: vertical; }

    input:focus, select:focus, textarea:focus {
        outline: none;
        border-color: #6d5dfc;
        box-shadow: 0 0 0 3px rgba(109, 93, 252, .12);
    }

    .hint { margin-top: 7px; color: #6b7280; font-size: 12px; }

    .error {
        margin-bottom: 22px;
        padding: 14px 16px;
        color: #991b1b;
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 8px;
        font-size: 14px;
    }

    .error ul { margin: 8px 0 0; padding-left: 20px; }

    .foto-lama {
        display: block;
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        margin-bottom: 12px;
    }

    .no-foto {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100px;
        height: 100px;
        margin-bottom: 12px;
        border-radius: 12px;
        background: #f3f4f6;
        color: #9ca3af;
        font-size: 12px;
    }

    .actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 10px;
        padding-top: 22px;
        border-top: 1px solid #e5e7eb;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 11px 18px;
        border: 0;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-primary { background: #6d5dfc; color: #fff; }
    .btn-primary:hover { background: #5948ed; }
    .btn-secondary { background: #f3f4f6; color: #374151; }
    .btn-secondary:hover { background: #e5e7eb; }

    @media (max-width: 600px) {
        .page { margin: 20px auto; padding: 0 12px; }
        .card { padding: 20px; }
        .form-grid { grid-template-columns: 1fr; gap: 0; }
        .form-group.full { grid-column: auto; }
    }
</style>

<div class="page">
    <div class="page-header">
        <h2>Edit User</h2>
        <p>Perbarui informasi akun MeUI Labs.</p>
    </div>

    <div class="card">
        <h3 class="section-title">Informasi Akun</h3>

        @if ($errors->any())
            <div class="error">
                <strong>Data belum bisa diperbarui.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.update', $user->id) }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input id="name" type="text" name="name"
                           value="{{ old('name', $user->name) }}"
                           maxlength="100" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email"
                           value="{{ old('email', $user->email) }}"
                           maxlength="100" required>
                </div>

                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input id="password" type="password" name="password"
                           minlength="6" placeholder="Kosongkan jika tidak diubah">
                    <div class="hint">Isi hanya jika ingin mengganti password.</div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input id="password_confirmation" type="password"
                           name="password_confirmation" minlength="6"
                           placeholder="Ulangi password baru">
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="designer" {{ old('role', $user->role) == 'designer' ? 'selected' : '' }}>Designer</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="no_telepon">Nomor Telepon</label>
                    <input id="no_telepon" type="text" name="no_telepon"
                           value="{{ old('no_telepon', $user->no_telepon) }}"
                           maxlength="20">
                </div>

                <div class="form-group full">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat">{{ old('alamat', $user->alamat) }}</textarea>
                </div>

                <div class="form-group full">
                    <label for="foto">Foto Profil</label>

                    @if ($user->foto && file_exists(public_path('uploads/users/' . $user->foto)))
                        <img src="{{ asset('uploads/users/' . $user->foto) }}"
                             alt="Foto {{ $user->name }}" class="foto-lama">
                    @else
                        <div class="no-foto">Belum ada foto</div>
                    @endif

                    <input id="foto" type="file" name="foto"
                           accept=".jpg,.jpeg,.png">
                    <div class="hint">Pilih foto baru jika ingin mengganti foto. Maksimal 2 MB.</div>
                </div>
            </div>

            <div class="actions">
                <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>