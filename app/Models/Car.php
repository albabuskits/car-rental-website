<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;
use App\Traits\LogsActivity;

class Car extends Model
{
    use Searchable, LogsActivity;

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

    public function nextAvailableDate()
    {
        $latestReturn = $this->bookings()
            ->whereIn('status', ['pending', 'confirmed', 'active'])
            ->where('return_date', '>=', now())
            ->max('return_date');

        if (!$latestReturn) {
            return null;
        }

        return $latestReturn->addDay()->startOfDay();
    }

    public function isAvailableBetween($pickupDate, $returnDate): bool
    {
        return !$this->bookings()
            ->whereIn('status', ['pending', 'confirmed', 'active'])
            ->where(function ($q) use ($pickupDate, $returnDate) {
                $q->whereBetween('pickup_date', [$pickupDate, $returnDate])
                  ->orWhereBetween('return_date', [$pickupDate, $returnDate])
                  ->orWhere(function ($q2) use ($pickupDate, $returnDate) {
                      $q2->where('pickup_date', '<=', $pickupDate)
                         ->where('return_date', '>=', $returnDate);
                  });
            })
            ->exists();
    }

    public function activityLabel(): string
    {
        return $this->brand . ' ' . $this->model . ' (#' . $this->id . ')';
    }

    public static function loadNextAvailableDates($cars)
    {
        $carIds = $cars->pluck('id');
        $latestReturns = \DB::table('bookings')
            ->selectRaw('car_id, MAX(return_date) as max_return')
            ->whereIn('car_id', $carIds)
            ->whereIn('status', ['pending', 'confirmed', 'active'])
            ->where('return_date', '>=', now())
            ->groupBy('car_id')
            ->get()
            ->keyBy('car_id');

        $cars->each(function ($car) use ($latestReturns) {
            $row = $latestReturns->get($car->id);
            if ($row) {
                $date = \Carbon\Carbon::parse($row->max_return)->addDay()->startOfDay();
                $car->next_available_date = $date->format('Y-m-d');
            } else {
                $car->next_available_date = null;
            }
        });
    }

    public function toSearchableArray()
    {
        return [
            'brand' => $this->brand,
            'model' => $this->model,
            'year' => $this->year,
            'category' => $this->category,
            'description' => $this->description,
            'transmission' => $this->transmission,
            'fuel_type' => $this->fuel_type,
            'status' => $this->status,
            'price_per_day' => (float) $this->price_per_day,
        ];
    }
}
