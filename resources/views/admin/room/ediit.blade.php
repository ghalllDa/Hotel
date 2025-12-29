<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kamar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">Edit Kamar</h5>
                    <small>{{ $hotel->nama_hotel }}</small>
                </div>

                <div class="card-body">

                    <form method="POST"
                          action="{{ route('admin.hotels.rooms.update', [$hotel->id, $room->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama Kamar</label>
                            <input type="text"
                                   name="nama_kamar"
                                   class="form-control"
                                   value="{{ $room->nama_kamar }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number"
                                   name="harga"
                                   class="form-control"
                                   value="{{ $room->harga }}"
                                   min="0"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="tersedia" {{ $room->status == 'tersedia' ? 'selected' : '' }}>
                                    Tersedia
                                </option>
                                <option value="penuh" {{ $room->status == 'penuh' ? 'selected' : '' }}>
                                    Penuh
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fasilitas</label>
                            <textarea name="fasilitas"
                                      class="form-control"
                                      rows="3">{{ is_array($room->fasilitas) ? implode(', ', $room->fasilitas) : '' }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.hotels.show', $hotel->id) }}"
                               class="btn btn-secondary">
                                Batal
                            </a>

                            <button class="btn btn-warning">
                                Update Kamar
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
