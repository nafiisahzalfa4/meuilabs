<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan | MeUI Labs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">

    <div class="text-center mb-5">
        <h1 class="fw-bold">Layanan MeUI Labs</h1>
        <p class="text-muted">Temukan layanan kreatif dan digital kami.</p>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
            Kembali ke Beranda
        </a>
    </div>

    <div class="row g-4">

        @forelse($services as $service)
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">

                    @if($service->gambar)
                        <img
                            src="{{ asset('images/services/' . $service->gambar) }}"
                            class="card-img-top"
                            alt="{{ $service->nama_jasa }}"
                            style="height: 220px; object-fit: cover;">
                    @else
                        <div class="bg-secondary-subtle d-flex align-items-center justify-content-center"
                             style="height: 220px;">
                            Tidak ada gambar
                        </div>
                    @endif

                    <div class="card-body">
                        <h5 class="fw-bold">{{ $service->nama_jasa }}</h5>

                        <p class="text-muted">
                            {{ \Illuminate\Support\Str::limit($service->deskripsi, 100) }}
                        </p>

                        <h6 class="text-success fw-bold">
                            Rp {{ number_format($service->harga, 0, ',', '.') }}
                        </h6>

                        <a href="{{ route('services.show', $service->id) }}"
                           class="btn btn-success w-100 mt-2">
                            Lihat Detail
                        </a>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <h5>Belum ada layanan tersedia.</h5>
            </div>
        @endforelse

    </div>

</div>

</body>
</html>