<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::where('is_available', true);

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
        if ($request->filled('min_price')) {
            $query->where('price_per_day', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price_per_day', '<=', $request->max_price);
        }

        $cars = $query->with('images')->paginate(12);
        return response()->json($cars);
    }

    public function show(Car $car)
    {
        $car->load('images');
        return response()->json($car);
    }

    public function featured()
    {
        $cars = Car::where('is_available', true)->with('images')->inRandomOrder()->take(3)->get();
        return response()->json($cars);
    }

    public function similar(Car $car)
    {
        $cars = Car::where('id', '!=', $car->id)
            ->where('category', $car->category)
            ->where('is_available', true)
            ->with('images')
            ->take(3)
            ->get();
        return response()->json($cars);
    }
}
