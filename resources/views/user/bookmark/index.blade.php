<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hotel Tersimpan
        </h2>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <a href="{{ route('dashboard') }}"
                   class="text-blue-600 hover:text-blue-800 text-sm">
                    ← Kembali ke Dashboard
                </a>
            </div>

            @if($hotels->count() === 0)
                <div class="bg-white rounded-lg shadow p-8 text-center text-gray-500">
                    Belum ada hotel yang disimpan
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    @foreach($hotels as $hotel)
                        <div class="bg-white rounded-lg shadow hotel-card" data-id="{{ $hotel->id }}">

                            <img
                                src="{{ $hotel->images->first()
                                    ? asset('storage/' . $hotel->images->first()->path)
                                    : asset('img/no-image.png') }}"
                                class="w-full h-40 object-cover rounded-t-lg">

                            <div class="p-4">

                                <!-- NAMA + LOKASI + BOOKMARK (SAMA DENGAN DASHBOARD) -->
                                <div class="flex justify-between items-start gap-2">
                                    <div>
                                        <h4 class="font-semibold text-lg">
                                            {{ $hotel->nama_hotel }}
                                        </h4>

                                        <p class="text-sm text-gray-500">
                                            {{ $hotel->lokasi }}
                                        </p>
                                    </div>

                                    <!-- BOOKMARK BUTTON -->
                                    <button
                                        class="bookmark-btn saved"
                                        data-id="{{ $hotel->id }}"
                                        title="Hapus dari simpanan">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M6 2h12v20l-6-3-6 3V2z"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                fill="currentColor"
                                            />
                                        </svg>
                                    </button>
                                </div>

                                <p class="mt-3 font-bold text-orange-600">
                                    Rp {{ number_format($hotel->harga,0,',','.') }} / malam
                                </p>

                                <a href="/hotels/{{ $hotel->id }}"
                                   class="block mt-4 text-center bg-blue-600 text-white py-2 rounded">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- SCRIPT BOOKMARK (UNSAVE + REMOVE CARD) -->
    <script>
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.bookmark-btn');
            if (!btn) return;

            const hotelId = btn.dataset.id;
            const card = btn.closest('.hotel-card');

            fetch(`/hotels/${hotelId}/bookmark`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(() => {
                card.remove();
            });
        });
    </script>

    <!-- STYLE BOOKMARK (SAMA DENGAN DASHBOARD) -->
    <style>
        .bookmark-btn {
            background: white;
            border-radius: 9999px;
            padding: 6px;
            border: 1px solid #e5e7eb;
            cursor: pointer;
        }

        .bookmark-btn svg {
            color: #9ca3af;
        }

        .bookmark-btn.saved svg {
            color: #ef4444;
        }
    </style>
</x-app-layout>
