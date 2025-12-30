<x-app-layout>
<div class="min-h-[80vh] flex justify-center pt-10">
    <div class="w-full max-w-2xl">

        <h1 class="text-2xl font-bold mb-6 text-center">Edit Promo Kamar</h1>

        <div class="bg-white shadow-xl rounded-xl p-8"
             x-data="promoForm(
                {{ $hotels->toJson() }},
                {{ $promo->room->hotel_id }},
                {{ $promo->room_id }}
             )">

            <form method="POST" action="{{ route('promo.update', $promo->id) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- HOTEL -->
                <div>
                    <label class="block mb-1 text-sm font-medium">Hotel</label>
                    <select x-model="selectedHotel"
                            class="w-full rounded-lg border-gray-300">
                        <option value="">-- Pilih Hotel --</option>
                        <template x-for="hotel in hotels" :key="hotel.id">
                            <option :value="hotel.id"
                                    x-text="hotel.nama_hotel">
                            </option>
                        </template>
                    </select>
                </div>

                <!-- KAMAR -->
                <div>
                    <label class="block mb-1 text-sm font-medium">Kamar</label>
                    <select name="room_id"
                            x-model="selectedRoom"
                            class="w-full rounded-lg border-gray-300"
                            required>
                        <template x-for="room in filteredRooms" :key="room.id">
                            <option :value="room.id"
                                    x-text="room.nama_kamar + ' - Rp ' + room.harga.toLocaleString()">
                            </option>
                        </template>
                    </select>
                </div>

                <!-- JUDUL -->
                <input type="text"
                       name="judul"
                       value="{{ $promo->judul }}"
                       class="w-full rounded-lg border-gray-300"
                       required>

                <!-- DISKON -->
                <input type="number"
                       name="diskon"
                       value="{{ $promo->diskon }}"
                       class="w-full rounded-lg border-gray-300"
                       required>

                <!-- TANGGAL -->
                <div class="grid grid-cols-2 gap-4">
                    <input type="date"
                           name="tanggal_mulai"
                           value="{{ $promo->tanggal_mulai }}"
                           class="rounded-lg border-gray-300">

                    <input type="date"
                           name="tanggal_selesai"
                           value="{{ $promo->tanggal_selesai }}"
                           class="rounded-lg border-gray-300">
                </div>

                <div class="flex justify-center gap-4 pt-6">
                    <a href="{{ route('promo.index') }}"
                       class="px-6 py-2 border rounded-lg">
                        Batal
                    </a>
                    <button class="px-8 py-2 bg-blue-600 text-white rounded-lg">
                        Update Promo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function promoForm(hotels, hotelId, roomId) {
    return {
        hotels,
        selectedHotel: hotelId,
        selectedRoom: roomId,

        get filteredRooms() {
            let hotel = this.hotels.find(h => h.id == this.selectedHotel);
            return hotel ? hotel.rooms : [];
        }
    }
}
</script>
</x-app-layout>
