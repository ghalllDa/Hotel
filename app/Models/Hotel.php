<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_hotel',
        'lokasi',
        'deskripsi',
        'latitude',
        'longitude',
        'harga',
        'fasilitas',
        'gambar',
        'stars',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function images()
    {
        return $this->hasMany(HotelImage::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // ✅ RELASI BOOKMARK
    public function savedByUsers()
    {
        return $this->belongsToMany(
            User::class,
            'saved_hotels',
            'hotel_id',
            'user_id'
        );
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

}
