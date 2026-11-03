
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Designer - MeUI Labs</title>

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

        <a href="{{ route('designer.dashboard') }}" class="active">Dashboard</a>
        <a href="{{ route('portfolios.index') }}">Portofolio</a>
        <a href="{{ route('orders.index') }}">Pesanan</a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout">Logout</button>
        </form>
    </div>

    <div class="main">

        <div class="header">
            <h1>Dashboard Designer</h1>
            <span>{{ Auth::user()->name }}</span>
        </div>

        <div class="welcome">
            <h2>Halo, {{ Auth::user()->name }}!</h2>
            <p>Selamat datang di dashboard MeUI Labs.</p>
            <p>Kelola pesanan dan proyek desainmu melalui halaman ini.</p>
        </div>

        <div class="stats">
            <div class="card">
                <p>Total Pesanan</p>
                <h2>0</h2>
            </div>

            <div class="card">
                <p>Proyek Berjalan</p>
                <h2>0</h2>
            </div>

            <div class="card">
                <p>Proyek Selesai</p>
                <h2>0</h2>
            </div>

            <div class="card">
                <p>Total Portofolio</p>
                <h2>0</h2>
            </div>
        </div>

        <div class="content">
            <h3>Aktivitas Terbaru</h3>

            <div class="empty">
                Belum ada aktivitas terbaru.
            </div>
        </div>

    </div>

</body>
</html>
