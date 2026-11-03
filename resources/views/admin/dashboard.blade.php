
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Super Admin - MeUI Labs</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f6f9;
            color: #333;
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            background: #202b46;
            color: white;
            padding: 25px 20px;
        }

        .sidebar h2 {
            margin-bottom: 35px;
        }

        .sidebar a {
            display: block;
            color: #dce2ee;
            text-decoration: none;
            padding: 13px 15px;
            border-radius: 7px;
            margin-bottom: 8px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #354568;
            color: white;
        }

        .logout {
            width: 100%;
            padding: 12px;
            margin-top: 25px;
            border: none;
            border-radius: 7px;
            background: #e05252;
            color: white;
            cursor: pointer;
        }

        .main {
            margin-left: 240px;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .welcome {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .welcome h2 {
            margin-bottom: 10px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 12px;
        }

        .card p {
            color: #777;
            margin-bottom: 12px;
        }

        .card h2 {
            font-size: 30px;
            color: #202b46;
        }

        .content {
            background: white;
            padding: 22px;
            border-radius: 12px;
        }

        .content h3 {
            margin-bottom: 15px;
        }

        .empty {
            padding: 35px;
            text-align: center;
            color: #888;
        }

        @media(max-width: 900px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width: 600px) {
            .sidebar {
                width: 180px;
            }

            .main {
                margin-left: 180px;
                padding: 15px;
            }

            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>MeUI Labs</h2>

        <a href="{{ route('admin.dashboard') }}" class="active">Dashboard</a>
        <a href="{{ route('user.index') }}">Kelola Pengguna</a>
        <a href="{{ route('services.index') }}">Kelola Layanan</a>
        <a href="{{ route('portfolios.index') }}">Kelola Portofolio</a>
        <a href="{{ route('orders.index') }}">Kelola Pesanan</a>
        <a href="{{ route('projects.index') }}">Kelola Proyek</a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout">Logout</button>
        </form>
    </div>

    <div class="main">

        <div class="header">
            <h1>Dashboard Super Admin</h1>
            <span>{{ Auth::user()->name }}</span>
        </div>

        <div class="welcome">
            <h2>Selamat Datang, {{ Auth::user()->name }}!</h2>
            <p>Selamat datang di halaman Super Admin MeUI Labs.</p>
            <p>Kelola pengguna, layanan, portofolio, pesanan, dan proyek melalui dashboard ini.</p>
        </div>

        <div class="stats">
            <div class="card">
                <p>Total Pengguna</p>
                <h2>0</h2>
            </div>

            <div class="card">
                <p>Total Layanan</p>
                <h2>0</h2>
            </div>

            <div class="card">
                <p>Total Pesanan</p>
                <h2>0</h2>
            </div>

            <div class="card">
                <p>Total Proyek</p>
                <h2>0</h2>
            </div>
        </div>

        <div class="content">
            <h3>Informasi Sistem</h3>

            <div class="empty">
                Selamat bekerja! Pantau dan kelola seluruh aktivitas MeUI Labs melalui menu di sebelah kiri.
            </div>
        </div>

    </div>

</body>
</html>
