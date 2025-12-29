<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Room;

class RoomController extends Controller
{
    // List kamar per hotel
    public function index(Hotel $hotel)
    {
        $rooms = $hotel->rooms;
        return view('admin.room.index', compact('hotel', 'rooms'));
    }

    // FORM tambah kamar
    public function create(Hotel $hotel)
    {
        return view('admin.room.create', compact('hotel'));
    }

    // Simpan kamar baru
    public function store(Request $request, Hotel $hotel)
    {
        $request->validate([
            'nama_kamar' => 'required',
            'harga' => 'required|numeric|min:0',
            'status' => 'required',
        ]);

        $fasilitas = $request->fasilitas
            ? array_map('trim', explode(',', $request->fasilitas))
            : [];

        $hotel->rooms()->create([
            'nama_kamar' => $request->nama_kamar,
            'harga' => max(0, $request->harga),
            'status' => $request->status,
            'fasilitas' => $fasilitas,
        ]);

        return redirect()
            ->route('admin.hotels.show', $hotel->id)
            ->with('success', 'Kamar berhasil ditambahkan');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT KAMAR (FIX SESUAI PERMINTAAN)
    |--------------------------------------------------------------------------
    */
    public function edit($hotelId, $roomId)
    {
        $hotel = Hotel::findOrFail($hotelId);
        $room  = Room::findOrFail($roomId);

        return view('admin.room.ediit', compact('hotel', 'room'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE KAMAR (FIX SESUAI PERMINTAAN)
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $hotelId, $roomId)
    {
        $room = Room::findOrFail($roomId);

        $data = $request->validate([
            'nama_kamar' => 'required|string',
            'harga'      => 'required|integer|min:0',
            'status'     => 'required|in:tersedia,Penuh',
            'fasilitas'  => 'nullable|string',
        ]);

        if (isset($data['fasilitas'])) {
            $data['fasilitas'] = array_map(
                'trim',
                explode(',', $data['fasilitas'])
            );
        }

        $room->update($data);

        return redirect()
            ->route('admin.hotels.show', $hotelId)
            ->with('success', 'Kamar berhasil diperbarui');

    }

    // Hapus kamar
    public function destroy(Hotel $hotel, Room $room)
    {
        $room->delete();

        return redirect()
            ->route('hotels.rooms.index', $hotel->id)
            ->with('success', 'Kamar berhasil dihapus');
    }
}
