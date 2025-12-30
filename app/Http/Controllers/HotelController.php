<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * API: hotel terdekat / search
     */
    public function nearby(Request $request)
    {
        $lat = $request->query('lat');
        $lng = $request->query('lng');
        $radius = 10; // KM default
        $keyword = $request->query('q', '');
        $checkin = $request->query('checkin');
        $checkout = $request->query('checkout');
        $guests = $request->query('guests');

        // Query dasar
        $hotels = Hotel::query()->whereNotNull('latitude')->whereNotNull('longitude');

        // Filter nama hotel
        if (!empty($keyword)) {
            $hotels->where('nama_hotel', 'like', "%{$keyword}%");
        }

        // Filter radius lokasi
        if ($lat && $lng) {
            $hotels->selectRaw("
                *,
                (6371 * acos(
                    cos(radians(?)) *
                    cos(radians(latitude)) *
                    cos(radians(longitude) - radians(?)) +
                    sin(radians(?)) *
                    sin(radians(latitude))
                )) AS distance
            ", [$lat, $lng, $lat])
            ->having('distance', '<=', $radius)
            ->orderBy('distance', 'asc');
        }

        // Filter kamar tersedia sesuai checkin/checkout & jumlah tamu
        if ($checkin && $checkout && $guests) {
            $hotels->whereHas('rooms', function($q) use ($checkin, $checkout, $guests) {
                $q->where('capacity', '>=', $guests)
                  ->whereDoesntHave('bookings', function($b) use ($checkin, $checkout) {
                      $b->where(function($query) use ($checkin, $checkout) {
                          $query->whereBetween('checkin', [$checkin, $checkout])
                                ->orWhereBetween('checkout', [$checkin, $checkout])
                                ->orWhere(function($q2) use ($checkin, $checkout) {
                                    $q2->where('checkin', '<=', $checkin)
                                       ->where('checkout', '>=', $checkout);
                                });
                      });
                  });
            });
        }

        $hotels = $hotels->get();

        // Format JSON
        $data = $hotels->map(function($hotel) {
            return [
                'id' => $hotel->id,
                'nama_hotel' => $hotel->nama_hotel,
                'lokasi' => $hotel->lokasi,
                'latitude' => $hotel->latitude,
                'longitude' => $hotel->longitude,
                'harga' => $hotel->harga,
                'fasilitas' => $hotel->fasilitas,
                'image' => $hotel->gambar ?? '/img/no-image.png',
            ];
        });

        return response()->json($data);
    }

    /**
     * Detail hotel
     */
    public function show($id)
    {
        $hotel = Hotel::with(['images', 'rooms'])->findOrFail($id);

        return view('penginapan.show', compact('hotel'));
    }
}
