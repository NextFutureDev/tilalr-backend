<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\HasImageCleanup;

class Portfolio extends Model
{
    use HasFactory, HasTranslations, HasImageCleanup;

    protected $fillable = [
        'name',
        'category',
        'image',
    ];

    public $translatable = ['name', 'category'];
}
