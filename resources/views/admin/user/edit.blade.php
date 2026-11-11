@extends('admin.layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Edit User</h4>
            <p class="text-muted mb-0">Perbarui informasi akun MeUI Labs.</p>
        </div>

        <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <h5 class="fw-bold mb-4 pb-3 border-bottom">Informasi Akun</h5>

            <form action="{{ route('admin.user.update', $user->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Kosongkan jika tidak ingin mengubah">
                        <small class="text-muted">Isi hanya jika ingin mengganti password.</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation"
                               class="form-control"
                               placeholder="Ulangi password baru">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>Customer</option>
                            <option value="designer" {{ old('role', $user->role) == 'designer' ? 'selected' : '' }}>Designer</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="no_telepon"
                               class="form-control"
                               value="{{ old('no_telepon', $user->no_telepon) }}">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" rows="4"
                                  class="form-control">{{ old('alamat', $user->alamat) }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Foto Profil Saat Ini</label>

                        @if($user->foto && file_exists(public_path('uploads/users/' . $user->foto)))
                            <div class="mb-3">
                                <img src="{{ asset('uploads/users/' . $user->foto) }}"
                                     alt="Foto {{ $user->name }}"
                                     class="rounded"
                                     style="width:120px;height:120px;object-fit:cover;">
                            </div>
                        @else
                            <div class="mb-3 d-flex align-items-center justify-content-center rounded"
                                 style="width:120px;height:120px;background:#f1f4f5;color:#839096;">
                                <i class="bi bi-person fs-1"></i>
                            </div>
                        @endif

                        <label class="form-label">Ganti Foto Profil</label>
                        <input type="file" name="foto"
                               class="form-control @error('foto') is-invalid @enderror"
                               accept=".jpg,.jpeg,.png">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti foto. Maksimal 2 MB.</small>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.user.index') }}" class="btn btn-light border">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection