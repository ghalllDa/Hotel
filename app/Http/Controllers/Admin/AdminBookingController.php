<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Support\Str;

class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('room.hotel')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function approve(Booking $booking)
    {
        if ($booking->status !== 'paid') {
            return back()->withErrors('Booking belum dibayar');
        }

        // ===== KODE LAMA (TIDAK DIUBAH) =====
        $booking->update([
            'status'      => 'approved',
            'ticket_code' => 'TICKET-' . strtoupper(Str::random(8)),
            'approved_at' => now(),
        ]);

        // ===== FIX FINAL (PASTI MASUK DB) =====
        Ticket::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'ticket_code' => $booking->ticket_code,
                'check_in'    => $booking->check_in,
                'check_out'   => $booking->check_out,
            ]
        );

        return back()->with('success', 'Pesanan disetujui & tiket dibuat');
    }

    public function reject(Booking $booking)
    {
        $booking->update([
            'status' => 'rejected'
        ]);

        return back()->with('success', 'Pesanan ditolak');
    }
}
