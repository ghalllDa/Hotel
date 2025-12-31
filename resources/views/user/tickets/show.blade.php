<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">🎫 Detail Tiket</h1>

        <div class="border rounded p-6 space-y-2">
            <p><b>Kode Tiket:</b> {{ $ticket->ticket_code }}</p>
            <p><b>Hotel:</b> {{ $ticket->booking->room->hotel->nama_hotel }}</p>
            <p><b>Kamar:</b> {{ $ticket->booking->room->nama_kamar }}</p>
            <p><b>Check-in:</b> {{ $ticket->check_in }}</p>
            <p><b>Check-out:</b> {{ $ticket->check_out }}</p>
        </div>

        <a href="{{ route('tickets.index') }}"
           class="inline-block mt-4 text-blue-600 underline">
            ← Kembali ke Tiket Saya
        </a>
    </div>
</x-app-layout>
