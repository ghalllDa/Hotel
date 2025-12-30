<x-app-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-4">Pembayaran</h1>
        <p>Kamar: <strong>{{ $room->nama_kamar }}</strong></p>
        <p>Jumlah malam: <strong>{{ $jumlahMalam }}</strong></p>
        <p>Total harga: <strong>Rp {{ number_format($totalHarga, 0, ',', '.') }}</strong></p>
    </div>

    <!-- Midtrans Snap JS -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script type="text/javascript">
        snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                window.location.href = "{{ route('booking.success', $booking->id) }}";
            },
            onPending: function (result) {
                alert("Pembayaran pending: " + result.status_message);
            },
            onError: function (result) {
                alert("Pembayaran gagal: " + result.status_message);
            },
            onClose: function () {
                alert('Popup pembayaran ditutup.');
            }
        });
    </script>
</x-app-layout>