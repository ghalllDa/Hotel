<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();
        return view('admin.hotels.index', compact('hotels'));
    }

    public function create()
    {
        return view('admin.hotels.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_hotel' => 'required|string',
            'lokasi' => 'required|string',
            'harga' => 'required|integer',
            'gambar' => 'nullable|image',
            'fasilitas' => 'required|string',
        ]);

        if($request->hasFile('gambar')){
            $data['gambar'] = $request->file('gambar')->store('hotels', 'public');
        }

        Hotel::create($data);
        return redirect()->route('hotels.index')->with('success', 'Hotel berhasil ditambahkan!');
    }

    public function edit(Hotel $hotel)
    {
        return view('admin.hotels.edit', compact('hotel'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $data = $request->validate([
            'nama_hotel' => 'required|string',
            'lokasi' => 'required|string',
            'harga' => 'required|integer',
            'gambar' => 'nullable|image',
            'fasilitas' => 'required|string',
        ]);

        if($request->hasFile('gambar')){
            // hapus file lama
            if($hotel->gambar) Storage::disk('public')->delete($hotel->gambar);
            $data['gambar'] = $request->file('gambar')->store('hotels', 'public');
        }

        $hotel->update($data);
        return redirect()->route('hotels.index')->with('success', 'Hotel berhasil diperbarui!');
    }

    public function destroy(Hotel $hotel)
    {
        if($hotel->gambar) Storage::disk('public')->delete($hotel->gambar);
        $hotel->delete();
        return redirect()->route('hotels.index')->with('success', 'Hotel berhasil dihapus!');
    }
}
