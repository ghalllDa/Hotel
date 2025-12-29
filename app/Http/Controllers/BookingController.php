<?php

namespace App\Http\Controllers;

use App\Models\Room;

class BookingController extends Controller
{
    /**
     * Tampilkan halaman booking
     */
    public function create(Room $room)
    {
        // 🔥 PAKSA LOAD RELASI HOTEL + IMAGES
        $room->load([
            'hotel.images'
        ]);

        return view('booking.create', compact('room'));
    }
}
