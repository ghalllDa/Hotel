<x-app-layout>
    {{-- <div class="bg-blue-50 p-6">
        <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold text-blue-700 mb-4">Admin Operasional Dashboard</h1>
            <a href="{{ route('hotels.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                Kelola Hotel & Kamar
            </a>
        </div>
    </div> --}}

    <div class="max-w-7xl mx-auto px-6 mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($hotels as $hotel)
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="font-bold text-lg">{{ $hotel->nama_hotel }}</h2>
            <p>Total Kamar: {{ $hotel->rooms->count() }}</p>
            <p>Fasilitas: {{ $hotel->fasilitas }}</p>
        </div>
        @endforeach
    </div>
</x-app-layout>
