<x-app-layout>
    <div class="max-w-5xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">🎫 Tiket Saya</h1>

        @forelse($tickets as $ticket)
            <div class="border rounded p-4 mb-4">
                <p><b>Hotel:</b> {{ $ticket->booking->room->hotel->nama_hotel }}</p>
                <p><b>Kamar:</b> {{ $ticket->booking->room->nama_kamar }}</p>
                <p><b>Kode Tiket:</b> {{ $ticket->ticket_code }}</p>

                <a href="{{ route('tickets.show', $ticket) }}"
                   class="text-blue-600 underline">
                    Lihat Detail
                </a>
            </div>
        @empty
            <p>Belum ada tiket.</p>
        @endforelse
    </div>
</x-app-layout>
