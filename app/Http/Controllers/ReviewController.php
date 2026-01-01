<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Booking $booking)
    {
        // hanya pemilik booking
        abort_if($booking->user_id !== auth()->id(), 403);

        // hanya booking approved
        if ($booking->status !== 'approved') {
            return redirect()->back()
                ->with('error', 'Booking belum disetujui hotel');
        }

        // cegah double review
        if ($booking->review) {
            return redirect()->back()
                ->with('error', 'Booking ini sudah direview');
        }

        return view('reviews.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 403);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'hotel_id' => $booking->room->hotel_id, // ✅ BENAR
            'booking_id' => $booking->id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()
            ->route('user.order-history')
            ->with('success', 'Terima kasih atas review Anda!');
    }
}
