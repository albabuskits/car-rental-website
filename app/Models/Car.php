<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'user_id', 'brand', 'model', 'year', 'category', 'transmission',
        'fuel_type', 'seats', 'ac', 'price_per_day', 'image',
        'description', 'is_available', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'ac' => 'boolean',
            'is_available' => 'boolean',
            'price_per_day' => 'decimal:2',
        ];
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function images()
    {
        return $this->hasMany(CarImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(CarImage::class)->where('is_primary', true);
    }
}
