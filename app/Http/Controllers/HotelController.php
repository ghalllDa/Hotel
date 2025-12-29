<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function nearby(Request $request)
    {
        $lat = $request->lat;
        $lng = $request->lng;
        $radius = 10; // KM
        $checkin = $request->checkin;
        $checkout = $request->checkout;
        $guests = $request->guests;

        return response()->json(
            Hotel::select(
                'id',
                'nama_hotel',
                'lokasi',
                'harga',
                'fasilitas',
                'latitude',
                'longitude'
            )
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get()
        );
    }

    public function show($id)
    {
        $hotel = Hotel::with(['images', 'rooms'])->findOrFail($id);

        return view('penginapan.show', compact('hotel'));
    }
}

