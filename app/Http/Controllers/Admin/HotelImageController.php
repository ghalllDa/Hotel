<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotelImage;
use Illuminate\Support\Facades\Storage;

class HotelImageController extends Controller
{
    public function destroy(HotelImage $image)
    {
        // hapus file fisik
        if (Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }

        // hapus dari database
        $image->delete();

        return back()->with('success', 'Gambar berhasil dihapus');
    }
}
