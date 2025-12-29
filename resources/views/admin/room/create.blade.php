<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kamar</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
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

                        {{-- GAMBAR KAMAR (BARU) --}}
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

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.hotels.show', $hotel->id) }}"
                               class="btn btn-secondary">
                                Kembali
                            </a>

                            <button type="submit" class="btn btn-primary">
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
