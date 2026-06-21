<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('brand', 'like', '%' . $request->search . '%')
                  ->orWhere('model', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }
        if ($request->filled('brands')) {
            $brands = explode(',', $request->brands);
            $query->whereIn('brand', $brands);
        }
        if ($request->filled('min_price')) {
            $query->where('price_per_day', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price_per_day', '<=', $request->max_price);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price_per_day', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price_per_day', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->latest();
        }

        $cars = $query->with('images')->paginate(12);

        Car::loadNextAvailableDates($cars->getCollection());

        return response()->json($cars);
    }

    public function show(Car $car)
    {
        $car->load('images');
        $car->next_available_date = optional($car->nextAvailableDate())->format('Y-m-d');
        return response()->json($car);
    }

    public function featured()
    {
        $cars = Car::with('images')->latest()->take(6)->get();

        Car::loadNextAvailableDates($cars);

        return response()->json($cars);
    }

    public function similar(Car $car)
    {
        $cars = Car::where('id', '!=', $car->id)
            ->where('category', $car->category)
            ->with('images')
            ->take(3)
            ->get();

        Car::loadNextAvailableDates($cars);

        return response()->json($cars);
    }
}