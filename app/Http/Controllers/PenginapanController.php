<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class PenginapanController extends Controller
{
    public function show($id)
    {
        $hotel = Hotel::with(['images', 'rooms'])->findOrFail($id);

        return view('penginapan.show', compact('hotel'));
    }
}
