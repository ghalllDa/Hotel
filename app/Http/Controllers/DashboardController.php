<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        // ===============================
        // USER
        // ===============================
        if ($role === 'user') {

            $hotels = Hotel::with([
                    'images',
                    'rooms' => function ($q) {
                        $q->where('status', 'tersedia');
                    }
                ])
                ->whereHas('rooms', function ($q) {
                    $q->where('status', 'tersedia');
                })
                ->get();

            // ✅ FIX DI SINI (BUKAN bookmarks())
            $bookmarkedHotelIds = $user
                ->savedHotels()
                ->pluck('hotels.id')
                ->toArray();

            return view('dashboard.user', compact(
                'hotels',
                'bookmarkedHotelIds'
            ));
        }

        // ===============================
        // ADMIN
        // ===============================
        if (in_array($role, ['admin_operasional', 'admin_konten'])) {
            $hotels = Hotel::with('images')->get();
            return view("dashboard.$role", compact('hotels'));
        }

        abort(403);
    }
}
