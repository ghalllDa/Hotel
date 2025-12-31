<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'booking_id',
        'ticket_code',
        'check_in',
        'check_out',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
