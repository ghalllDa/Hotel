<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promo;
use App\Models\Hotel; // ⬅️ INI YANG KURANG

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::with('room.hotel')->latest()->get();
        return view('admin.promo.index', compact('promos'));
    }

    public function create()
    {
        $hotels = Hotel::with('rooms')->get();
        return view('admin.promo.create', compact('hotels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required',
            'judul' => 'required',
            'diskon' => 'required|integer',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
        ]);

        Promo::create($request->all());

        return redirect()->route('promo.index');
    }
}
