<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MeUI Labs</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,.08);
            margin: 20px 0; /* Tambahan agar tidak terlalu mepet di layar kecil */
        }

        h2 {
            text-align: center;
            color: #243b55;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            color: #777;
            margin-bottom: 28px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #243b55;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background: #365575;
        }

        .error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 6px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="login-container">

    <h2>MeUI Labs</h2>
    <p class="subtitle">Silakan daftar akun baru</p>

    <!-- Menampilkan pesan error validasi -->
    @if($errors->any())
        <div class="error">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.post') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="Masukkan nama lengkap"
                required
            >
        </div>

        <div class="form-group">
            <label>Email</label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Masukkan email"
                required
            >
        </div>

        <div class="form-group">
            <label>Password</label>
            <input
                type="password"
                name="password"
                placeholder="Minimal 6 karakter"
                required
            >
        </div>

        <div class="form-group">
            <label>Konfirmasi Password</label>
            <!-- name harus password_confirmation agar validasi 'confirmed' di controller jalan -->
            <input
                type="password"
                name="password_confirmation"
                placeholder="Ulangi password"
                required
            >
        </div>

        <button type="submit">Daftar</button>

        <div style="text-align: center; margin-top: 15px; font-size: 14px;">
            Sudah punya akun? <a href="{{ route('login') }}" style="color: #243b55; font-weight: bold; text-decoration: none;">Login di sini</a>
        </div>

    </form>

</div>

</body>
</html>