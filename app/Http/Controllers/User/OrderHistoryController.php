<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class OrderHistoryController extends Controller
{
    public function index()
    {
        $orders = Booking::with(['room', 'hotel', 'ticket'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.order-history.index', compact('orders'));
    }

    /**
     * Helper untuk label status
     */
    public function statusLabel($status)
    {
        return match (strtolower($status)) {
            'pending'   => '<span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">Menunggu Pembayaran</span>',
            'paid'      => '<span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-700">Menunggu Konfirmasi Admin</span>',
            'approved'  => '<span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">Disetujui</span>',
            'rejected'  => '<span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">Ditolak</span>',
            'completed' => '<span class="px-2 py-1 text-xs rounded bg-gray-200 text-gray-700">Selesai</span>',
            default     => '<span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-600">Unknown</span>',
        };
    }
}
