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

        // TAMBAHAN: ubah fasilitas string jadi array
        $fasilitas = $request->fasilitas
            ? array_map('trim', explode(',', $request->fasilitas))
            : [];

        $hotel->rooms()->create([
            'nama_kamar' => $request->nama_kamar,
            'harga' => max(0, $request->harga), // TAMBAHAN: anti minus
            'status' => $request->status,
            'fasilitas' => $fasilitas,
        ]);

        // TAMBAHAN: redirect ke halaman detail hotel
        return redirect()
            ->route('admin.hotels.show', $hotel->id)
            ->with('success', 'Kamar berhasil ditambahkan');
    }

    // FORM edit kamar
    public function edit(Hotel $hotel, Room $room)
    {
        return view('admin.room.edit', compact('hotel', 'room'));
    }

    // Update data kamar
    public function update(Request $request, Hotel $hotel, Room $room)
    {
        $request->validate([
            'nama_kamar' => 'required',
            'harga' => 'required|numeric|min:0',
            'status' => 'required',
        ]);

        $room->update([
            'nama_kamar' => $request->nama_kamar,
            'harga' => max(0, $request->harga),
            'status' => $request->status,
            'fasilitas' => $request->fasilitas
                ? array_map('trim', explode(',', $request->fasilitas))
                : [],
        ]);

        return redirect()
            ->route('hotels.rooms.index', $hotel->id)
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
