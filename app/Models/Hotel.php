<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    protected $fillable = [
        'title',
        'address',
        'phone',
        'email',
        'stars',
        'rooms',
        'site',
        'description',
        'short_description',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(HotelImage::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(HotelReview::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
}
