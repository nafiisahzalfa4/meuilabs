<style>
    * { box-sizing: border-box; }

    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f5f6fa;
        color: #1f2937;
    }

    .page { max-width: 1250px; margin: 35px auto; padding: 0 20px; }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 25px;
    }

    .page-header h2 { margin: 0 0 8px; font-size: 26px; }
    .page-header p { margin: 0; color: #6b7280; font-size: 14px; }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 15px;
        border: 0;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-primary { background: #6d5dfc; color: white; }
    .btn-primary:hover { background: #5948ed; }
    .btn-edit { background: #fff7ed; color: #c2410c; }
    .btn-edit:hover { background: #ffedd5; }
    .btn-delete { background: #fef2f2; color: #b91c1c; }
    .btn-delete:hover { background: #fee2e2; }

    .alert {
        margin-bottom: 20px;
        padding: 14px 16px;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
        border-radius: 9px;
        font-size: 14px;
    }

    .table-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
        overflow: hidden;
    }

    .table-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 22px;
        border-bottom: 1px solid #e5e7eb;
    }

    .table-heading h3 { margin: 0; font-size: 16px; }
    .table-heading span { color: #6b7280; font-size: 13px; }

    .table-scroll { overflow-x: auto; }

    table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
    }

    th {
        padding: 14px 16px;
        background: #f9fafb;
        color: #6b7280;
        text-align: left;
        text-transform: uppercase;
        letter-spacing: .04em;
        font-size: 11px;
    }

    td {
        padding: 15px 16px;
        border-top: 1px solid #f0f1f4;
        font-size: 13px;
        vertical-align: middle;
    }

    tbody tr:hover { background: #fafaff; }

    .preview {
        width: 105px;
        height: 70px;
        object-fit: cover;
        border: 1px solid #e5e7eb;
        border-radius: 9px;
        display: block;
    }

    .no-image {
        width: 105px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: #f3f4f6;
        color: #9ca3af;
        font-size: 11px;
    }

    .portfolio-title { font-weight: 600; color: #111827; }
    .portfolio-description {
        max-width: 280px;
        margin-top: 5px;
        color: #6b7280;
        line-height: 1.5;
    }

    .category {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        background: #ede9fe;
        color: #5b21b6;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .designer-name { font-weight: 600; }

    .aksi { display: flex; align-items: center; gap: 7px; }
    .aksi form { margin: 0; }

    .empty {
        padding: 50px 20px;
        text-align: center;
        color: #6b7280;
    }

    .empty strong {
        display: block;
        margin-bottom: 8px;
        color: #374151;
        font-size: 16px;
    }

    .empty p { margin: 0 0 18px; font-size: 13px; }

    @media (max-width: 600px) {
        .page { margin: 22px auto; padding: 0 12px; }
        .page-header { align-items: flex-start; flex-direction: column; }
        .table-heading { align-items: flex-start; flex-direction: column; gap: 8px; }
    }
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h2>Portofolio Desain</h2>
            <p>Kelola dan tampilkan hasil karya UI/UX MeUI Labs.</p>
        </div>

        <a href="{{ route('portfolios.create') }}" class="btn btn-primary">
            + Tambah Portofolio
        </a>
    </div>

    @if (session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <div class="table-card">
        <div class="table-heading">
            <h3>Daftar Portofolio</h3>
            <span>Total {{ $portofolios->count() }} karya</span>
        </div>

        <div class="table-scroll">
            @if ($portofolios->isNotEmpty())
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Preview</th>
                            <th>Informasi Proyek</th>
                            <th>Kategori</th>
                            <th>Designer</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($portofolios as $portfolio)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    @if ($portfolio->gambar)
                                        <img
                                            src="{{ asset('storage/' . $portfolio->gambar) }}"
                                            alt="Preview {{ $portfolio->judul }}"
                                            class="preview"
                                        >
                                    @else
                                        <div class="no-image">Belum ada gambar</div>
                                    @endif
                                </td>

                                <td>
                                    <div class="portfolio-title">
                                        {{ $portfolio->judul }}
                                    </div>
                                    <div class="portfolio-description">
                                        {{ \Illuminate\Support\Str::limit($portfolio->deskripsi ?: 'Belum ada deskripsi.', 100) }}
                                    </div>
                                </td>

                                <td>
                                    <span class="category">
                                        @switch($portfolio->kategori)
                                            @case('website') Website @break
                                            @case('mobile') Mobile App @break
                                            @case('dashboard') Dashboard @break
                                            @default Lainnya
                                        @endswitch
                                    </span>
                                </td>

                                <td>
                                    <span class="designer-name">
                                        {{ optional($portfolio->designer)->name ?? 'Designer tidak tersedia' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="aksi">
                                        <a
                                            href="{{ route('portfolios.edit', $portfolio->id) }}"
                                            class="btn btn-edit"
                                        >Edit</a>

                                        <form
                                            action="{{ route('portfolios.destroy', $portfolio->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus portofolio {{ $portfolio->judul }}?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-delete">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty">
                    <strong>Belum ada portofolio</strong>
                    <p>Tambahkan hasil desain website, aplikasi mobile, atau dashboard pertama kamu.</p>
                    <a href="{{ route('portfolios.create') }}" class="btn btn-primary">
                        Tambah Portofolio
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>