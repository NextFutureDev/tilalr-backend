<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'trip_type',
        'trip_slug',
        'trip_title',
        'preferred_date',
        'guests',
        'notes',
        'details',
        'status',
        'admin_contacted',
        'contacted_at',
        'admin_notes',
        'converted_booking_id',
    ];

    protected $casts = [
        'details' => 'array',
        'preferred_date' => 'date',
        'admin_contacted' => 'boolean',
        'contacted_at' => 'datetime',
    ];

    /**
     * Get the booking this reservation was converted to
     */
    public function convertedBooking()
    {
        return $this->belongsTo(Booking::class, 'converted_booking_id');
    }

    /**
     * The user who owns this reservation (if linked)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get a display-friendly string for the details JSON
     */
    public function getDetailsDisplayAttribute()
    {
        $details = $this->details;

        if (is_null($details)) {
            return null;
        }

        if (is_array($details) || $details instanceof \Illuminate\Contracts\Arrayable) {
            return json_encode($details, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        }

        return (string) $details;
    }

    /**
     * Check if reservation is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if reservation has been contacted
     */
    public function hasBeenContacted(): bool
    {
        return $this->admin_contacted || $this->status === 'contacted';
    }

    /**
     * Check if reservation was converted to booking
     */
    public function isConverted(): bool
    {
        return $this->status === 'converted' && $this->converted_booking_id !== null;
    }

    /**
     * Get trip type label
     */
    public function getTripTypeLabelAttribute(): string
    {
        $labels = [
            'school' => 'School Trip',
            'corporate' => 'Corporate Trip',
            'family' => 'Family Trip',
            'private' => 'Private Group Trip',
        ];

        return $labels[$this->trip_type] ?? $this->trip_type ?? 'General';
    }

    /**
     * Get status badge color for admin panel
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'contacted' => 'info',
            'confirmed' => 'success',
            'converted' => 'primary',
            'cancelled' => 'danger',
            default => 'gray',
        };
    }

    /**
     * Get guest count from booking details or fall back to main guests column
     */
    public function getBookingGuestCountAttribute(): ?int
    {
        if (isset($this->details['numberOfGuests'])) {
            return intval($this->details['numberOfGuests']);
        }
        return $this->guests ?? null;
    }

    /**
     * Get room information summary from booking details
     */
    public function getRoomInfoAttribute(): ?array
    {
        if (isset($this->details['roomCount']) || isset($this->details['roomsNearEachOther'])) {
            return [
                'roomCount' => intval($this->details['roomCount'] ?? 1),
                'roomsNearEachOther' => boolval($this->details['roomsNearEachOther'] ?? false),
                'roomsNearEachOtherCount' => intval($this->details['roomsNearEachOtherCount'] ?? 1),
                'roomType' => $this->details['roomType'] ?? null,
            ];
        }
        return null;
    }

    /**
     * Get a human-readable room summary
     */
    public function getRoomSummaryAttribute(): ?string
    {
        $info = $this->room_info;
        if (!$info) {
            return null;
        }

        $summary = $info['roomCount'] . ' ' . ($info['roomCount'] > 1 ? 'rooms' : 'room');

        if ($info['roomsNearEachOther']) {
            $summary .= ' (adjacent: ' . $info['roomsNearEachOtherCount'] . ')';
        }

        if ($info['roomType']) {
            $summary .= ' - ' . $info['roomType'];
        }

        return $summary;
    }

    /**
     * Scope for pending reservations
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for not contacted reservations
     */
    public function scopeNotContacted($query)
    {
        return $query->where('admin_contacted', false);
    }

    /**
     * Scope by trip type
     */
    public function scopeOfTripType($query, string $type)
    {
        return $query->where('trip_type', $type);
    }

    /**
     * Scope by date range
     */
    public function scopeDateRange($query, $from, $to)
    {
        if ($from) {
            $query->where('created_at', '>=', $from);
        }
        if ($to) {
            $query->where('created_at', '<=', $to);
        }
        return $query;
    }
}
