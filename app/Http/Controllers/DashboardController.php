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
        // Ambil user saat ini
        $user = Auth::user();
        $role = $user->role;

        // ⬇️ FIX: ambil hotel + gambar + hanya kamar tersedia
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

        // Pilih view berdasarkan role (TIDAK DIUBAH)
        return match ($role) {
            'user' => view('dashboard.user', compact('hotels')),
            'admin_operasional' => view('dashboard.admin_operasional', compact('hotels')),
            'admin_konten' => view('dashboard.admin_konten', compact('hotels')),
            default => abort(403),
        };
    }
}
