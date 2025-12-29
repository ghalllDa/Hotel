<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $hotel->nama_hotel }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .hotel-banner {
            height: 320px;
            background-image: url('{{ asset('storage/' . $hotel->gambar) }}');
            background-size: cover;
            background-position: center;
            border-radius: 12px;
            position: relative;
        }

        .hotel-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,.45);
            border-radius: 12px;
        }

        .hotel-info {
            position: absolute;
            bottom: 20px;
            left: 30px;
            color: #fff;
        }
    </style>
</head>
<body class="bg-light">

<div class="container my-4">

    {{-- BANNER HOTEL --}}
    <div class="hotel-banner mb-4">
        <div class="hotel-overlay"></div>

        <div class="hotel-info">
            <h2 class="mb-1">{{ $hotel->nama_hotel }}</h2>
            <p class="mb-3">{{ $hotel->lokasi }}</p>

            <a href="{{ route('hotels.rooms.create', $hotel->id) }}"
               class="btn btn-primary">
                ➕ Tambah Kamar
            </a>
        </div>
    </div>

    {{-- DAFTAR KAMAR --}}
    <h4 class="mb-3">Daftar Kamar</h4>

    @if ($hotel->rooms->count())
        <div class="row">
            @foreach ($hotel->rooms as $room)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $room->nama_kamar }}</h5>

                            <p class="mb-1">
                                <strong>Harga:</strong>
                                Rp {{ number_format($room->harga, 0, ',', '.') }} / malam
                            </p>

                            <p class="mb-1">
                                <strong>Status:</strong>
                                <span class="badge bg-{{ $room->status == 'tersedia' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($room->status) }}
                                </span>
                            </p>

                            <p class="mb-0">
                                <strong>Fasilitas:</strong><br>
                                {{ is_array($room->fasilitas) ? implode(', ', $room->fasilitas) : '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-warning">
            Belum ada kamar untuk hotel ini.
        </div>
    @endif

</div>

</body>
</html>
