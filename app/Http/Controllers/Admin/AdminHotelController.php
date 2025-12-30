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
        $hotels = Hotel::with('images')->get();
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
            'lokasi'     => 'required|string',
            'deskripsi'  => 'required|string',
            'latitude'   => 'required',
            'longitude'  => 'required',
            'harga'      => 'required|integer',
            'fasilitas'  => 'required|string',
            'images.*'   => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // SIMPAN HOTEL (TANPA GAMBAR)
        $hotel = Hotel::create([
            'nama_hotel' => $data['nama_hotel'],
            'lokasi'     => $data['lokasi'],
            'deskripsi'  => $data['deskripsi'],
            'latitude'   => $data['latitude'],
            'longitude'  => $data['longitude'],
            'harga'      => $data['harga'],
            'fasilitas'  => $data['fasilitas'],
        ]);

        // SIMPAN MULTI IMAGE
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
            ->with('success', 'Hotel berhasil ditambahkan!');
    }

    public function edit(Hotel $hotel)
    {
        $hotel->load('images');
        return view('admin.hotels.edit', compact('hotel'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $request->validate([
            'nama_hotel' => 'required|string',
            'lokasi'     => 'required|string',
            'deskripsi'  => 'required|string',
            'harga'      => 'required|numeric',
            'fasilitas'  => 'required|string',
            'latitude'   => 'required',
            'longitude'  => 'required',
            'images.*'   => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // UPDATE DATA HOTEL
        $hotel->update([
            'nama_hotel' => $request->nama_hotel,
            'lokasi'     => $request->lokasi,
            'deskripsi'  => $request->deskripsi,
            'harga'      => $request->harga,
            'fasilitas'  => $request->fasilitas,
            'latitude'   => $request->latitude,
            'longitude'  => $request->longitude,
        ]);

        // TAMBAH GAMBAR BARU (TIDAK HAPUS YANG LAMA)
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
        // HAPUS SEMUA GAMBAR
        foreach ($hotel->images as $img) {
            Storage::disk('public')->delete($img->path);
            $img->delete();
        }

        $hotel->delete();

        return redirect()
            ->route('hotels.index')
            ->with('success', 'Hotel berhasil dihapus!');
    }

    public function show(Hotel $hotel)
    {
        // ⬇️ SATU-SATUNYA PERUBAHAN DI SINI
        $hotel->load(['images', 'rooms.promos']);

        return view('admin.hotels.show', compact('hotel'));
    }
}
