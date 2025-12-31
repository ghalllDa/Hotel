<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Hotel; // ✅ TAMBAHAN (RELATE BOOKMARK)

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ===============================
    // ✅ RELATION BOOKMARK / SAVED HOTEL
    // ===============================
    public function savedHotels()
    {
        return $this->belongsToMany(
            Hotel::class,
            'saved_hotels',
            'user_id',
            'hotel_id'
        )->withTimestamps();
    }

    /**
     * Alias convenience method for controller calls that expect ->bookmarks()
     * (keeps backward compatibility with code that uses ->bookmarks()).
     */
    public function bookmarks()
    {
        return $this->savedHotels();
    }
}
