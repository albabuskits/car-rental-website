<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use App\Traits\LogsActivity;

class Booking extends Model
{
    use Searchable, LogsActivity;

    protected $fillable = [
        'user_id', 'car_id', 'pickup_date', 'return_date',
        'total_price', 'status', 'customer_name', 'customer_email',
        'customer_phone', 'customer_license', 'delivery_location',
    ];

    protected function casts(): array
    {
        return [
            'pickup_date' => 'datetime',
            'return_date' => 'datetime',
            'total_price' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function activityLabel(): string
    {
        return '#' . $this->id . ' - ' . ($this->customer_name ?? '');
    }

    public function toSearchableArray()
    {
        return [
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'customer_phone' => $this->customer_phone,
            'car_brand' => $this->car?->brand,
            'car_model' => $this->car?->model,
            'status' => $this->status,
        ];
    }
}
