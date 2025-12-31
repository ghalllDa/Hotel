<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kamar</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- STYLE MEWAH (TANPA UBAH LOGIC) -->
    <style>
        body {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(99,102,241,0.15), transparent 40%),
                radial-gradient(circle at bottom right, rgba(59,130,246,0.15), transparent 40%),
                linear-gradient(135deg, #f8fafc, #eef2ff);
        }

        .card {
            border-radius: 20px;
            border: none;
            overflow: hidden;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(6px);
        }

        .card-header {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            padding: 1.5rem;
        }

        .card-header h5 {
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .card-header small {
            opacity: 0.85;
        }

        .card-body {
            padding: 2rem;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #374151;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            padding: 0.55rem 0.75rem;
            border: 1px solid #e5e7eb;
            background-color: #f9fafb;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #fff;
            border-color: #2563eb;
            box-shadow: 0 0 0 0.15rem rgba(37,99,235,0.25);
        }

        textarea {
            resize: none;
        }

        .btn {
            border-radius: 12px;
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1e40af, #2563eb);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1e3a8a, #1d4ed8);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #e5e7eb, #d1d5db);
            border: none;
            color: #374151;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #d1d5db, #9ca3af);
        }

        .alert-danger {
            border-radius: 12px;
            font-size: 0.85rem;
        }

        small.text-muted {
            font-size: 0.75rem;
        }

        /* SHADOW LUXURY */
        .shadow-lg {
            box-shadow:
                0 25px 50px -12px rgba(0,0,0,0.25);
        }
    </style>
</head>

<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg">
                <div class="card-header text-white">
                    <h5 class="mb-0">Tambah Kamar</h5>
                    <small>{{ $hotel->nama_hotel }}</small>
                </div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- FORM --}}
                    <form method="POST"
                          action="{{ route('hotels.rooms.store', $hotel->id) }}"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Kamar</label>
                            <input type="text" name="nama_kamar" class="form-control"
                                   value="{{ old('nama_kamar') }}"
                                   placeholder="Contoh: Deluxe Room" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga per Malam</label>
                            <input type="number" name="harga" class="form-control"
                                   value="{{ old('harga') }}"
                                   placeholder="Contoh: 500000" min="0" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kapasitas Orang</label>
                            <input type="number"
                                   name="capacity"
                                   class="form-control"
                                   value="{{ old('capacity') }}"
                                   placeholder="Contoh: 2"
                                   min="1"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="tersedia">Tersedia</option>
                                <option value="penuh">Penuh</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fasilitas</label>
                            <textarea name="fasilitas" class="form-control" rows="3"
                                      placeholder="AC, TV, WiFi, Sarapan">{{ old('fasilitas') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar Kamar</label>
                            <input type="file"
                                   name="gambar"
                                   class="form-control"
                                   accept="image/*">
                            <small class="text-muted">
                                JPG / PNG, max 2MB
                            </small>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.hotels.show', $hotel->id) }}"
                               class="btn btn-secondary px-4">
                                Kembali
                            </a>

                            <button type="submit" class="btn btn-primary px-4">
                                Simpan Kamar
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
