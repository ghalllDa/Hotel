<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id', 'check_in', 'check_out', 'jumlah_tamu', 'nama_pemesan',
        'no_hp', 'catatan', 'total_harga', 'status', 'transaction_id'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}