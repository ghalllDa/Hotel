<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Review Hotel {{ $booking->hotel->nama_hotel }}
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto py-10">
        <form method="POST" action="{{ route('reviews.store', $booking->id) }}"
            class="bg-white p-6 rounded-lg shadow space-y-4">
            @csrf

            {{-- RATING --}}
            <div>
                <label class="block font-semibold mb-2">Rating</label>

                <div class="flex flex-row-reverse justify-end gap-1 text-2xl rating">
                    @for ($i = 5; $i >= 1; $i--)
                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden" required>
                        <label for="star{{ $i }}" class="cursor-pointer text-gray-300 hover:text-yellow-400">
                            ★
                        </label>
                    @endfor
                </div>
            </div>


            {{-- KOMENTAR --}}
            <div>
                <label class="block font-semibold mb-2">Komentar</label>
                <textarea name="comment" rows="4" class="w-full border rounded p-2"
                    placeholder="Bagaimana pengalaman Anda?"></textarea>
            </div>

            <button class="bg-blue-600 hover:bg-blue-700
                           text-white px-4 py-2 rounded">
                Kirim Review
            </button>
        </form>
    </div>
</x-app-layout>

<style>
.rating input:checked ~ label {
    color: #facc15; /* yellow-400 */
}
</style>
