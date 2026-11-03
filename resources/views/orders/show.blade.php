
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Meuilabs</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6fa;
            color: #333;
            padding: 35px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 15px;
        }

        .header h2 {
            color: #172554;
            font-size: 25px;
        }

        .header p {
            color: #777;
            margin-top: 7px;
            font-size: 14px;
        }

        .btn {
            display: inline-block;
            padding: 11px 18px;
            border-radius: 7px;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        .btn-back {
            background: #e5e7eb;
            color: #333;
        }

        .btn-edit {
            background: #172554;
            color: white;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.04);
        }

        .card h3 {
            color: #172554;
            font-size: 17px;
            margin-bottom: 20px;
            padding-bottom: 13px;
            border-bottom: 1px solid #eee;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
        }

        .info-item label {
            display: block;
            color: #888;
            font-size: 12px;
            margin-bottom: 7px;
        }

        .info-item p {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            word-break: break-word;
        }

        .status {
            display: inline-block;
            padding: 7px 13px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: capitalize;
        }

        .menunggu {
            background: #fff3cd;
            color: #856404;
        }

        .diproses {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .selesai {
            background: #d1fae5;
            color: #047857;
        }

        .dibatalkan {
            background: #fee2e2;
            color: #b91c1c;
        }

        .price {
            color: #172554 !important;
            font-size: 20px !important;
        }

        .notes {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            font-size: 14px;
            line-height: 1.7;
            color: #555;
            min-height: 50px;
        }

        .empty {
            color: #999 !important;
            font-weight: normal !important;
            font-style: italic;
        }

        @media (max-width: 650px) {
            body {
                padding: 18px;
            }

            .header {
                align-items: flex-start;
                flex-direction: column;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>
            <h2>Detail Pesanan</h2>
            <p>Informasi lengkap mengenai pesanan Meuilabs.</p>
        </div>

        <div>
            <a href="{{ route('orders.index') }}" class="btn btn-back">
                Kembali
            </a>

            @if(auth()->user()->role == 'admin')
                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-edit">
                    Edit Pesanan
                </a>
            @endif
        </div>
    </div>

    <!-- INFORMASI PESANAN -->
    <div class="card">
        <h3>Informasi Pesanan</h3>

        <div class="info-grid">

            <div class="info-item">
                <label>ID Pesanan</label>
                <p>#{{ $order->id }}</p>
            </div>

            <div class="info-item">
                <label>Tanggal Pesanan</label>
                <p>{{ \Carbon\Carbon::parse($order->tanggal_pesan)->format('d F Y') }}</p>
            </div>

            <div class="info-item">
                <label>Status Pesanan</label>
                <p>
                    <span class="status {{ $order->status }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
            </div>

            <div class="info-item">
                <label>Total Harga</label>
                <p class="price">
                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                </p>
            </div>

        </div>
    </div>


    
<!-- UBAH STATUS PESANAN -->
@if(auth()->user()->role == 'designer' && $order->designer_id == auth()->id())

    <div class="card">
        <h3>Perbarui Status Pesanan</h3>

        @if(session('success'))
            <div style="background: #d1fae5; color: #047857; padding: 12px; border-radius: 7px; margin-bottom: 15px;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: #fee2e2; color: #b91c1c; padding: 12px; border-radius: 7px; margin-bottom: 15px;">
                {{ $errors->first() }}
            </div>
        @endif

        @if(in_array($order->status, ['menunggu', 'diproses']))

            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div style="margin-bottom: 18px;">
                    <label style="display: block; margin-bottom: 8px; font-size: 13px; color: #777;">
                        Pilih Status Baru
                    </label>

                    <select name="status" required
                        style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 7px;">

                        @if($order->status == 'menunggu')
                            <option value="diproses">Diproses</option>
                        @endif

                        @if($order->status == 'diproses')
                            <option value="selesai">Selesai</option>
                        @endif

                    </select>
                </div>

                <button type="submit"
                    style="background: #172554; color: white; border: none; padding: 12px 20px; border-radius: 7px; cursor: pointer; font-weight: bold;">
                    Simpan Perubahan
                </button>
            </form>

        @else
            <p class="empty">
                Pesanan ini sudah {{ $order->status }} dan tidak dapat diperbarui lagi.
            </p>
        @endif
    </div>

@endif


    <!-- DATA CUSTOMER DAN DESIGNER -->
    <div class="card">
        <h3>Informasi Customer dan Designer</h3>

        <div class="info-grid">

            <div class="info-item">
                <label>Nama Customer</label>
                <p>{{ $order->customer->name ?? 'Tidak tersedia' }}</p>
            </div>

            <div class="info-item">
                <label>Email Customer</label>
                <p>{{ $order->customer->email ?? 'Tidak tersedia' }}</p>
            </div>

            <div class="info-item">
                <label>Nama Designer</label>
                <p>{{ $order->designer->name ?? 'Belum ditugaskan' }}</p>
            </div>

            <div class="info-item">
                <label>Email Designer</label>
                <p>{{ $order->designer->email ?? 'Belum ditugaskan' }}</p>
            </div>

        </div>
    </div>

    <!-- INFORMASI JASA -->
    <div class="card">
        <h3>Informasi Jasa</h3>

        <div class="info-grid">

            <div class="info-item">
                <label>Nama Jasa</label>
                <p>{{ $order->service->nama_jasa ?? 'Tidak tersedia' }}</p>
            </div>

            <div class="info-item">
                <label>Harga Jasa</label>
                <p>
                    Rp {{ number_format($order->service->harga ?? 0, 0, ',', '.') }}
                </p>
            </div>

        </div>

        <br>

        <div class="info-item">
            <label>Catatan Pesanan</label>

            <div class="notes">
                {{ $order->catatan ?: 'Tidak ada catatan untuk pesanan ini.' }}
            </div>
        </div>
    </div>

    <!-- INFORMASI PROJECT -->
    <div class="card">
        <h3>Informasi Project</h3>

        @if($order->project)

            <div class="info-grid">

                <div class="info-item">
                    <label>Nama Project</label>
                    <p>{{ $order->project->project_name }}</p>
                </div>

                <div class="info-item">
                    <label>Status Project</label>
                    <p>{{ ucfirst($order->project->status) }}</p>
                </div>

                <div class="info-item">
                    <label>Tanggal Mulai</label>
                    <p>
                        {{ $order->project->start_date
                            ? \Carbon\Carbon::parse($order->project->start_date)->format('d F Y')
                            : 'Belum ditentukan' }}
                    </p>
                </div>

                <div class="info-item">
                    <label>Deadline</label>
                    <p>
                        {{ $order->project->deadline
                            ? \Carbon\Carbon::parse($order->project->deadline)->format('d F Y')
                            : 'Belum ditentukan' }}
                    </p>
                </div>

                <div class="info-item">
                    <label>Progress Project</label>
                    <p>{{ $order->project->progress }}%</p>
                </div>

            </div>

        @else

            <p class="empty">Belum ada project yang dibuat untuk pesanan ini.</p>

        @endif
    </div>

</div>

</body>
</html>
