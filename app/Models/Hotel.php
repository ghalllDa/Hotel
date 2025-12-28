<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

   protected $fillable = [
    'nama_hotel',
    'lokasi',
    'latitude',
    'longitude',
    'harga',
    'fasilitas',
    'gambar',
];
       public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}


