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
            'latitude' => 'required',
            'longitude' => 'required',
            'harga' => 'required|integer',
            'fasilitas' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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
        $data = $request->validate([
            'nama_hotel' => 'required|string',
            'lokasi' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'harga' => 'required|integer',
            'fasilitas' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($hotel->gambar) {
                Storage::disk('public')->delete($hotel->gambar);
            }

            $data['gambar'] = $request->file('gambar')->store('hotels', 'public');
        }

        $hotel->update($data);

        return redirect()
            ->route('hotels.index')
            ->with('success', 'Hotel berhasil diperbarui!');
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

    public function search(Request $request)
    {
        $lat = $request->latitude;
        $lng = $request->longitude;
        $radius = 5;

        return Hotel::selectRaw("
            hotels.*,
            (6371 * acos(
                cos(radians(?))
                * cos(radians(latitude))
                * cos(radians(longitude) - radians(?))
                + sin(radians(?))
                * sin(radians(latitude))
            )) AS distance
        ", [$lat, $lng, $lat])
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | ✅ TAMBAHAN: DETAIL HOTEL (KLIK CARD)
    |--------------------------------------------------------------------------
    */
    public function show(Hotel $hotel)
    {
        return view('admin.hotels.show', compact('hotel'));
    }
}
