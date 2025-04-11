<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attraction extends Model
{
    protected $fillable = [
        'title',
        'begin', 'end',
        'description',
        'short_description',
        'address'
    ];

    protected $casts = [
        'begin' => 'datetime:H:i',
        'end' => 'datetime:H:i',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(AttractionImage::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(AttractionReview::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
}
