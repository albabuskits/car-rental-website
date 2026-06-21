<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use App\Models\DriverLicense;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::with('car')
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return response()->json($bookings);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'pickup_date' => 'required|date|after:today',
            'return_date' => 'required|date|after:pickup_date',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_license' => 'nullable|string|max:50',
            'delivery_location' => 'nullable|string|max:500',
        ]);

        $user = $request->user();

        $hasApprovedLicense = DriverLicense::where('user_id', $user->id)
            ->where('status', 'verified')
            ->where('is_verified', true)
            ->exists();
        if (!$hasApprovedLicense) {
            return response()->json([
                'message' => 'يجب توثيق رخصة القيادة الخاصة بك من قبل الإدارة قبل إجراء الحجز. قم بتحميل رخصتك من لوحة المستخدم وانتظر التوثيق.',
                'errors' => ['license' => ['رخصة القيادة غير موثقة']],
            ], 422);
        }

        $car = Car::findOrFail($validated['car_id']);

        if (!$car->isAvailableBetween($validated['pickup_date'], $validated['return_date'])) {
            $nextDate = optional($car->nextAvailableDate())->format('Y-m-d');
            $msg = 'السيارة غير متاحة في التواريخ المحددة.';
            if ($nextDate) {
                $msg .= ' يمكنك الحجز ابتداءً من ' . $nextDate . '.';
            }
            return response()->json([
                'message' => $msg,
                'errors' => ['dates' => [$msg]],
            ], 409);
        }
        $days = now()->parse($validated['pickup_date'])->diffInDays(now()->parse($validated['return_date'])) + 1;
        $basePrice = $car->price_per_day * $days;
        $taxAmount = config('app.tax_enabled', true) ? (float) config('app.tax_amount', 45) : 0;
        $validated['total_price'] = $basePrice + $taxAmount;
        $validated['user_id'] = $user->id;
        $validated['status'] = 'pending';

        $booking = Booking::create($validated);
        return response()->json($booking, 201);
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        return response()->json($booking->load('car'));
    }

    public function destroy(Booking $booking)
    {
        $this->authorize('delete', $booking);
        $booking->update(['status' => 'cancelled']);
        return response()->json(['message' => 'تم إلغاء الحجز']);
    }
}
