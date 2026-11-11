<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $service->nama_jasa }} | MeUI Labs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">

    <a href="{{ route('services.index') }}"
       class="btn btn-outline-secondary mb-4">
        Kembali ke Layanan
    </a>

    <div class="card border-0 shadow-sm">
        <div class="row g-0">

            <div class="col-md-6">
                @if($service->gambar)
                    <img
                        src="{{ asset('images/services/' . $service->gambar) }}"
                        class="img-fluid w-100 h-100"
                        alt="{{ $service->nama_jasa }}"
                        style="object-fit: cover; min-height: 350px;">
                @else
                    <div class="bg-secondary-subtle d-flex align-items-center justify-content-center h-100"
                         style="min-height: 350px;">
                        Tidak ada gambar
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <div class="card-body p-4 p-lg-5">

                    <h2 class="fw-bold">{{ $service->nama_jasa }}</h2>

                    <h4 class="text-success fw-bold my-3">
                        Rp {{ number_format($service->harga, 0, ',', '.') }}
                    </h4>

                    <hr>

                    <h6 class="fw-bold">Deskripsi Layanan</h6>

                    <p class="text-muted">
                        {{ $service->deskripsi }}
                    </p>

                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>