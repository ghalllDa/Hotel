<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use Carbon\Carbon;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function form($roomId)
    {
        $room = Room::findOrFail($roomId);
        return view('booking.form', compact('room'));
    }

    public function createPayment(Request $request)
    {
        $room = Room::findOrFail($request->room_id);

        $request->validate([
            'room_id' => 'required|integer|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'jumlah_tamu' => 'required|integer|min:1|max:' . $room->capacity,
            'nama_pemesan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'catatan' => 'nullable|string',
            
        ], [
            'jumlah_tamu.max' => 'Jumlah tamu melebihi kapasitas kamar.',
            'check_out.after' => 'Tanggal check-out harus setelah check-in.',
        ]);

        $request->validate([
            'jumlah_tamu' => [
                'required',
                'integer',
                'min:1',
                'max:' . $room->capacity,
            ],
        ], [
            'jumlah_tamu.max' => 'Jumlah tamu melebihi kapasitas kamar.',
        ]);

        // Setelah validasi sukses dan ambil $room

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);

        // Carbon diffInDays DEFAULT nya ABSOLUTE (selalu positif!)
        $nights = $checkIn->diffInDays($checkOut);  // Ini selalu >= 0

        // Proteksi ekstra (minimal 1 malam)
        if ($nights < 1) {
            return back()->withErrors(['check_out' => 'Tanggal check-out harus minimal 1 hari setelah check-in.']);
        }

        // Hitung total
        $totalPrice = $nights * $room->harga;

        // Cek overlapping (sama seperti sebelumnya)
        $overlapping = Booking::where('room_id', $room->id)
            ->whereIn('status', ['pending', 'paid'])
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->where(function ($q) use ($checkIn, $checkOut) {
                    $q->where('check_in', '<', $checkOut)
                        ->where('check_out', '>', $checkIn);
                });
            })
            ->exists();

        if ($overlapping) {
            return back()->withErrors(['check_in' => 'Kamar sudah dipesan pada tanggal tersebut. Silakan pilih tanggal lain.']);
        }

        // SEKARANG BARU SIMPAN BOOKING
        $booking = Booking::create([
            'room_id' => $room->id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'jumlah_tamu' => $request->jumlah_tamu,
            'nama_pemesan' => $request->nama_pemesan,
            'no_hp' => $request->no_hp,
            'catatan' => $request->catatan,
            'total_harga' => $totalPrice,
            'status' => 'pending',
        ]);

        // Generate order_id unik
        $orderId = 'BOOK-' . $booking->id . '-' . time();

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $totalPrice,  // pastikan integer
            ],
            'customer_details' => [
                'first_name' => $request->nama_pemesan,
                'phone' => $request->no_hp,
            ],
            'item_details' => [
                [
                    'id' => 'ROOM-' . $room->id,
                    'price' => (int) $room->harga,
                    'quantity' => $nights,
                    'name' => $room->nama_kamar . ' (' . $nights . ' malam)',
                ]
            ],
            'callbacks' => [
                'finish' => route('booking.success')
            ]
        ];

        try {
            // Simpan transaction_id dulu
            $booking->update(['transaction_id' => $orderId]);

            $snapUrl = \Midtrans\Snap::getSnapUrl($params);  // atau getSnapRedirectUrl kalau mau langsung redirect

            return redirect()->away($snapUrl);  // langsung ke halaman payment Midtrans

        } catch (\Exception $e) {
            // Kalau gagal, batalkan booking
            $booking->update(['status' => 'canceled']);

            // Log error untuk debug (lihat storage/logs/laravel.log)
            \Log::error('Midtrans Error: ' . $e->getMessage());

            return back()->withErrors(['payment' => 'Gagal menuju pembayaran. Silakan coba lagi. (Error: ' . $e->getMessage() . ')']);
        }
    }
    public function handleNotification(Request $request)
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);

        try {
            $notification = new Notification();

            $orderId = $notification->order_id;
            $status = $notification->transaction_status;
            $fraud = $notification->fraud_status;

            $booking = Booking::where('transaction_id', $orderId)->firstOrFail();

            if ($status == 'capture' || $status == 'settlement') {
                if ($fraud == 'challenge') {
                    $booking->update(['status' => 'challenge']);
                } else {
                    $booking->update(['status' => 'paid']);
                }
            } elseif ($status == 'cancel' || $status == 'deny' || $status == 'expire') {
                $booking->update(['status' => 'canceled']);
            } elseif ($status == 'pending') {
                $booking->update(['status' => 'pending']);
            }

            return response('OK', 200);
        } catch (\Exception $e) {
            return response('Error: ' . $e->getMessage(), 500);
        }
    }

    public function paymentSuccess(Request $request)
    {
        // Ambil order_id dari URL query parameter yang dikirim Midtrans
        $orderId = $request->query('order_id');

        if (!$orderId) {
            abort(404, 'Kode transaksi tidak ditemukan.');
        }

        // Cari booking berdasarkan transaction_id
        $booking = Booking::with('room')->where('transaction_id', $orderId)->first();

        if (!$booking) {
            abort(404, 'Booking tidak ditemukan.');
        }

        // Opsional: cek apakah status sudah paid (dari webhook)
        // Tapi karena Midtrans redirect ke sini saat status_code=200 & settlement, biasanya sudah paid

        return view('booking.success', compact('booking'));
    }
}