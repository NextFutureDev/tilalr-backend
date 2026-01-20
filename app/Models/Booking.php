<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'date',
        'guests',
        'details',
        'status',
        'payment_status'
    ];

    protected $casts = [
        'details' => 'array',
        'date' => 'date',
    ];

    /**
     * Get the booking reference number (ID + 1000 offset)
     * Example: ID 1 becomes reference 1001
     */
    public function getBookingNumberAttribute()
    {
        return $this->id + 1000;
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }
}