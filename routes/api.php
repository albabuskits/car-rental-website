<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ContactController;

/*
|--------------------------------------------------------------------------
| API Auth Routes
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');

/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
*/
Route::middleware('throttle:60,1')->group(function () {
    Route::get('/cars', [CarController::class, 'index']);
    Route::get('/cars/featured', [CarController::class, 'featured']);
    Route::get('/cars/{car}', [CarController::class, 'show']);
    Route::get('/cars/{car}/similar', [CarController::class, 'similar']);
    Route::post('/contact', [ContactController::class, 'store']);
    Route::get('/settings', function () {
        $currencySymbols = ['USD' => '$', 'SAR' => '﷼', 'AED' => 'د.إ', 'QAR' => '﷼', 'EUR' => '€'];
        $currencyCode = config('app.currency', 'USD');
        return response()->json([
            'currency' => [
                'code' => $currencyCode,
                'symbol' => $currencySymbols[$currencyCode] ?? '$',
            ],
            'tax' => [
                'enabled' => (bool) config('app.tax_enabled', true),
                'amount' => (float) config('app.tax_amount', 45),
            ],
        ]);
    });
});

/*
|--------------------------------------------------------------------------
| Authenticated API Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'throttle:120,1'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/user/license', [AuthController::class, 'license']);
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/{booking}', [BookingController::class, 'show']);
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy']);
});
