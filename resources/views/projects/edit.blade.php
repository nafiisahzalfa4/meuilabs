
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #333;
        }

        .container {
            max-width: 750px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,.08);
        }

        h2 {
            margin-top: 0;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input, select {
            width: 100%;
            padding: 11px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        .error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        button, .back {
            border: none;
            padding: 11px 18px;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        button {
            background: #0d6efd;
            color: white;
        }

        .back {
            background: #6c757d;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Project</h2>

    <form action="{{ route('projects.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Order</label>
            <select name="order_id" required>
                <option value="">-- Pilih Order --</option>

                @foreach($orders as $order)
                    <option value="{{ $order->id }}"
                        {{ old('order_id', $project->order_id) == $order->id ? 'selected' : '' }}>
                        #{{ $order->id }} -
                        {{ $order->customer->name ?? 'Pelanggan' }} -
                        {{ $order->service->nama_jasa ?? 'Layanan' }}
                    </option>
                @endforeach
            </select>

            @error('order_id')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Nama Project</label>
            <input type="text" name="project_name"
                value="{{ old('project_name', $project->project_name) }}" required>

            @error('project_name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Tanggal Mulai</label>
            <input type="date" name="start_date"
                value="{{ old('start_date', optional($project->start_date)->format('Y-m-d')) }}">

            @error('start_date')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Deadline</label>
            <input type="date" name="deadline"
                value="{{ old('deadline', optional($project->deadline)->format('Y-m-d')) }}">

            @error('deadline')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Progress (%)</label>
            <input type="number" name="progress" min="0" max="100"
                value="{{ old('progress', $project->progress) }}">

            @error('progress')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Status Project</label>
            <select name="status" required>
                <option value="not_started" {{ old('status', $project->status) == 'not_started' ? 'selected' : '' }}>
                    Belum Dimulai
                </option>
                <option value="process" {{ old('status', $project->status) == 'process' ? 'selected' : '' }}>
                    Sedang Diproses
                </option>
                <option value="revision" {{ old('status', $project->status) == 'revision' ? 'selected' : '' }}>
                    Revisi
                </option>
                <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>
                    Selesai
                </option>
            </select>

            @error('status')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="actions">
            <button type="submit">Simpan Perubahan</button>
            <a href="{{ route('projects.index') }}" class="back">Kembali</a>
        </div>
    </form>
</div>

</body>
</html>
