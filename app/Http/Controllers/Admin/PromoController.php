<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promo;
use App\Models\Hotel;

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

        return redirect()->route('promo.index')
            ->with('success', 'Promo berhasil ditambahkan');
    }

    /* =====================================================
     |  TAMBAHAN BARU (EDIT & HAPUS PROMO)
     |  KODE LAMA TIDAK DIUBAH
     ===================================================== */

    // FORM EDIT
    public function edit(Promo $promo)
    {
        $hotels = Hotel::with('rooms')->get();
        return view('admin.promo.edit', compact('promo', 'hotels'));
    }

    // UPDATE DATA
    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'room_id' => 'required',
            'judul' => 'required',
            'diskon' => 'required|integer|min:1|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $promo->update($request->all());

        return redirect()->route('promo.index')
            ->with('success', 'Promo berhasil diperbarui');
    }

    // HAPUS PROMO
    public function destroy(Promo $promo)
    {
        $promo->delete();

        return redirect()->route('promo.index')
            ->with('success', 'Promo berhasil dihapus');
    }
}
