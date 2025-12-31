<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // ✅ WAJIB ADA
        'room_id',
        'check_in',
        'check_out',
        'jumlah_tamu',
        'nama_pemesan',
        'no_hp',
        'catatan',
        'total_harga',
        'status',
        'transaction_id',
        'ticket_code',
        'approved_at',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function hotel()
    {
        return $this->hasOneThrough(
            Hotel::class,
            Room::class,
            'id',
            'id',
            'room_id',
            'hotel_id'
        );
    }

    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }
}
