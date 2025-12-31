<x-app-layout>
    <!-- HEADER -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <!-- CONTENT -->
    <div class="py-12 bg-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- INFO LOGIN -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            <!-- HOTEL LIST -->
            <div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">
                    Rekomendasi Hotel
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    @foreach($hotels as $hotel)
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition relative">

                            {{-- BOOKMARK --}}
                            @auth
                            @php
                                $isSaved = auth()->user()->savedHotels->contains($hotel->id);
                            @endphp

                            <button
                                class="bookmark-btn {{ $isSaved ? 'saved' : '' }}"
                                data-hotel-id="{{ $hotel->id }}"
                                type="button"
                            >
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <path d="M6 2h12v20l-6-3-6 3V2z"
                                          stroke="currentColor"
                                          stroke-width="1.5"
                                          fill="{{ $isSaved ? 'currentColor' : 'none' }}"/>
                                </svg>
                            </button>
                            @endauth
                            {{-- END BOOKMARK --}}

                            <img
                                src="{{ $hotel->gambar ?? 'https://source.unsplash.com/400x250/?hotel' }}"
                                class="rounded-t-lg w-full h-40 object-cover">

                            <div class="p-4">
                                <h4 class="font-semibold text-lg">
                                    {{ $hotel->nama_hotel }}
                                </h4>

                                <p class="text-sm text-gray-500">
                                    {{ $hotel->lokasi }}
                                </p>

                                <!-- FASILITAS -->
                                <div class="flex gap-2 text-xs text-blue-600 mt-2 flex-wrap">
                                    @foreach(explode(',', $hotel->fasilitas) as $fasilitas)
                                        <span class="bg-blue-100 px-2 py-1 rounded">
                                            {{ $fasilitas }}
                                        </span>
                                    @endforeach
                                </div>

                                <!-- HARGA -->
                                <div class="mt-4">
                                    <p class="text-sm text-gray-500">
                                        Mulai dari
                                    </p>
                                    <p class="text-lg font-bold text-orange-600">
                                        Rp {{ number_format($hotel->harga, 0, ',', '.') }} / malam
                                    </p>
                                </div>

                                <button
                                    class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    {{-- STYLE BOOKMARK (KHUSUS BOOKMARK) --}}
    <style>
        .bookmark-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            background: white;
            border-radius: 9999px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            z-index: 10;
        }

        .bookmark-btn svg {
            color: #c2c2c2;
        }

        .bookmark-btn.saved svg {
            color: #ef4444;
        }
    </style>

    {{-- JAVASCRIPT BOOKMARK --}}
    <script>
        document.querySelectorAll('.bookmark-btn').forEach(button => {
            button.addEventListener('click', function () {
                const hotelId = this.dataset.hotelId;
                const isSaved = this.classList.contains('saved');

                fetch(`/hotels/${hotelId}/bookmark`, {
                    method: isSaved ? 'DELETE' : 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(() => {
                    this.classList.toggle('saved');

                    const path = this.querySelector('path');
                    path.setAttribute(
                        'fill',
                        this.classList.contains('saved') ? 'currentColor' : 'none'
                    );
                });
            });
        });
    </script>

</x-app-layout>
