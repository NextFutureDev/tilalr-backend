<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class OtpCode extends Model
{
    use HasFactory;

    protected $fillable = ['phone', 'code', 'type', 'attempts', 'expires_at', 'used_at'];

    protected $dates = ['expires_at', 'used_at', 'created_at', 'updated_at'];

    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isUsed()
    {
        return !is_null($this->used_at);
    }

    public function markUsed()
    {
        $this->used_at = Carbon::now();
        $this->save();
    }
}
