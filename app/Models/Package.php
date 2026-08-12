<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name', 'slug', 'tier', 'tagline', 'description', 'price',
    'features', 'cover_color', 'image_path', 'is_featured', 'order', 'is_active',
])]
class Package extends Model
{
    protected function casts(): array
    {
        return [
            'features' => 'array',
            'price' => 'decimal:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function imageUrl(): ?string
    {
        return $this->image_path ? asset('storage/'.$this->image_path) : null;
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
