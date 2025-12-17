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
        return view('admin.operasional.room.index', compact('hotel', 'rooms'));
    }

    // Simpan kamar baru
    public function store(Request $request, Hotel $hotel)
    {
        $request->validate([
            'nama_kamar' => 'required',
            'harga' => 'required|numeric',
            'status' => 'required',
        ]);

        $hotel->rooms()->create([
            'nama_kamar' => $request->nama_kamar,
            'harga' => $request->harga,
            'status' => $request->status,
            'fasilitas' => $request->fasilitas,
        ]);

        return back()->with('success', 'Kamar berhasil ditambahkan');
    }
}
