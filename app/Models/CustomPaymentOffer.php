<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class CustomPaymentOffer extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'amount',
        'description',
        'unique_link',
        'payment_status',
        'moyasar_transaction_id',
        'created_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate unique link if not provided
            if (empty($model->unique_link)) {
                $model->unique_link = static::generateUniqueLink();
            }
            
            // Set default status
            if (empty($model->payment_status)) {
                $model->payment_status = 'pending';
            }
        });
    }

    /**
     * Generate a unique, secure payment link token
     */
    public static function generateUniqueLink(): string
    {
        do {
            // Use UUID v4 for non-guessable tokens
            $token = Str::uuid()->toString();
        } while (static::where('unique_link', $token)->exists());

        return $token;
    }

    /**
     * Get the admin who created this offer
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Check if payment is completed/paid
     */
    public function isPaid(): bool
    {
        return in_array($this->payment_status, ['paid', 'completed']);
    }

    /**
     * Alias for isPaid for backward compatibility
     */
    public function isCompleted(): bool
    {
        return $this->isPaid();
    }

    /**
     * Check if payment is pending
     */
    public function isPending(): bool
    {
        return $this->payment_status === 'pending';
    }

    /**
     * Check if payment failed
     */
    public function isFailed(): bool
    {
        return $this->payment_status === 'failed';
    }

    /**
     * Mark as paid/completed
     */
    public function markAsPaid($transactionId = null): void
    {
        $this->payment_status = 'paid';
        if ($transactionId) {
            $this->moyasar_transaction_id = $transactionId;
        }
        $this->save();
    }

    /**
     * Alias for markAsPaid for backward compatibility
     */
    public function markAsCompleted($transactionId = null): void
    {
        $this->markAsPaid($transactionId);
    }

    /**
     * Mark as failed
     */
    public function markAsFailed(): void
    {
        $this->payment_status = 'failed';
        $this->save();
    }

    /**
     * Mark as cancelled
     */
    public function markAsCancelled(): void
    {
        $this->payment_status = 'cancelled';
        $this->save();
    }

    /**
     * Get the full payment URL
     */
    public function getPaymentUrl(): string
    {
        $frontendUrl = config('app.frontend_url', 'http://localhost:3000');
        return $frontendUrl . '/en/pay-custom-offer/' . $this->unique_link;
    }

    /**
     * Scope: Only pending offers
     */
    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    /**
     * Scope: Only paid offers
     */
    public function scopePaid($query)
    {
        return $query->whereIn('payment_status', ['paid', 'completed']);
    }

    /**
     * Scope: By creator
     */
    public function scopeByCreator($query, $userId)
    {
        return $query->where('created_by', $userId);
    }
}
