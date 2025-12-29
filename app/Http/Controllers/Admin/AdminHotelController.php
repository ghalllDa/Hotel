<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminHotelController extends Controller
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
            'deskripsi' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'harga' => 'required|integer',
            'fasilitas' => 'required|string',
            'images.*' => 'image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('hotels', 'public');
        }

        Hotel::create($data);

        return redirect()
            ->route('hotels.index')
            ->with('success', 'Hotel berhasil ditambahkan!');
    }

    public function edit(Hotel $hotel)
    {
        return view('admin.hotels.edit', compact('hotel'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $request->validate([
            'nama_hotel' => 'required',
            'lokasi' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'fasilitas' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'images.*' => 'image|max:2048'
        ]);

        $hotel->update([
            'nama_hotel' => $request->nama_hotel,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'fasilitas' => $request->fasilitas,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        // SIMPAN GAMBAR BARU
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('hotels', 'public');

                $hotel->images()->create([
                    'path' => $path
                ]);
            }
        }

        return redirect()
            ->route('hotels.index')
            ->with('success', 'Hotel berhasil diperbarui');
    }

    public function destroy(Hotel $hotel)
    {
        if ($hotel->gambar) {
            Storage::disk('public')->delete($hotel->gambar);
        }

        $hotel->delete();

        return redirect()
            ->route('hotels.index')
            ->with('success', 'Hotel berhasil dihapus!');
    }
}
