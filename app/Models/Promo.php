<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'room_id',
        'judul',
        'diskon',
        'tanggal_mulai',
        'tanggal_selesai'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}

