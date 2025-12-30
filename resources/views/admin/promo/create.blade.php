<x-app-layout>

<div class="min-h-[80vh] flex justify-center pt-10">
    <div class="w-full max-w-2xl">

        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold">Tambah Promo Kamar</h1>
            <p class="text-gray-500">Pilih hotel & kamar untuk promo</p>
        </div>

        <div class="bg-white shadow-xl rounded-xl p-8"
             x-data="promoForm({{ $hotels->toJson() }})">

            <form method="POST" action="{{ route('promo.store') }}" class="space-y-5">
                @csrf

                <!-- PILIH HOTEL (AUTOCOMPLETE) -->
                <div class="relative">
                    <label class="block text-sm font-medium mb-1">Hotel</label>

                    <input type="text"
                           x-model="hotelSearch"
                           @focus="open = true"
                           @click.away="open = false"
                           placeholder="Ketik nama hotel..."
                           class="w-full rounded-lg border-gray-300">

                    <!-- DROPDOWN HASIL -->
                    <div x-show="open && filteredHotels.length"
                         x-cloak
                         class="absolute z-20 w-full bg-white border rounded-lg mt-1
                                max-h-56 overflow-y-auto shadow">

                        <template x-for="hotel in filteredHotels" :key="hotel.id">
                            <div
                                @click="
                                    selectedHotel = hotel.id;
                                    hotelSearch = hotel.nama_hotel;
                                    open = false;
                                "
                                class="px-4 py-2 hover:bg-blue-50 cursor-pointer text-sm">
                                <span x-text="hotel.nama_hotel"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- PILIH KAMAR -->
                <div>
                    <label class="block text-sm font-medium mb-1">Kamar</label>

                    <select name="room_id"
                            class="w-full rounded-lg border-gray-300"
                            required>

                        <option value="">-- Pilih Kamar --</option>

                        <template x-for="room in filteredRooms" :key="room.id">
                            <option :value="room.id"
                                    x-text="room.nama_kamar + ' — Rp ' + room.harga.toLocaleString()">
                            </option>
                        </template>
                    </select>
                </div>

                <!-- JUDUL -->
                <div>
                    <label class="block text-sm font-medium mb-1">Judul Promo</label>
                    <input type="text" name="judul"
                           class="w-full rounded-lg border-gray-300"
                           placeholder="Promo Akhir Tahun"
                           required>
                </div>

                <!-- DISKON -->
                <div>
                    <label class="block text-sm font-medium mb-1">Diskon (%)</label>
                    <input type="number" name="diskon"
                           class="w-full rounded-lg border-gray-300"
                           placeholder="20"
                           required>
                </div>

                <!-- TANGGAL -->
                <div class="grid grid-cols-2 gap-4">
                    <input type="date" name="tanggal_mulai"
                           class="rounded-lg border-gray-300" required>
                    <input type="date" name="tanggal_selesai"
                           class="rounded-lg border-gray-300" required>
                </div>

                <!-- ACTION -->
                <div class="flex justify-center gap-4 pt-6">
                    <a href="{{ route('promo.index') }}"
                       class="px-6 py-2 border rounded-lg">
                        Batal
                    </a>
                    <button class="px-8 py-2 bg-blue-600 text-white rounded-lg">
                        Simpan Promo
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
function promoForm(hotels) {
    return {
        hotels,
        hotelSearch: '',
        selectedHotel: null,
        open: false,

        get filteredHotels() {
            if (!this.hotelSearch) return this.hotels;

            return this.hotels.filter(h =>
                h.nama_hotel.toLowerCase()
                    .includes(this.hotelSearch.toLowerCase())
            );
        },

        get filteredRooms() {
            let hotel = this.hotels.find(h => h.id == this.selectedHotel);
            return hotel ? hotel.rooms : [];
        }
    }
}
</script>


</x-app-layout>
