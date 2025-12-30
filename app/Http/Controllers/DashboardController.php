<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard berdasarkan role
     */
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        // ===============================
        // USER → hanya hotel yg punya kamar tersedia
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

            return view('dashboard.user', compact('hotels'));
        }

        // ===============================
        // ADMIN → tampilkan SEMUA hotel
        // ===============================
        if (in_array($role, ['admin_operasional', 'admin_konten'])) {
            $hotels = Hotel::with('images')->get();

            return view("dashboard.$role", compact('hotels'));
        }

        abort(403);
    }
}
