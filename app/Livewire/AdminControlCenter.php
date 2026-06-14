<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Car;
use App\Models\Booking;
use App\Models\User;

class AdminControlCenter extends Component
{
    public $totalCars = 0;
    public $activeBookings = 0;
    public $totalUsers = 0;
    public $monthlyRevenue = 0;
    public $recentActivity = [];

    public function mount()
    {
        $this->totalCars = Car::count();
        $this->activeBookings = Booking::whereIn('status', ['confirmed', 'active'])->count();
        $this->totalUsers = User::count();
        $this->monthlyRevenue = Booking::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');

        $bookings = Booking::with(['car', 'user'])
            ->latest()
            ->take(4)
            ->get()
            ->map(function ($b) {
                return [
                    'id' => $b->id,
                    'type' => 'حجز',
                    'description' => 'حجز جديد من ' . $b->customer_name,
                    'detail' => $b->car ? $b->car->brand . ' ' . $b->car->model : 'غير محدد',
                    'time' => $b->created_at->diffForHumans(),
                    'status' => $b->status,
                ];
            });

        $this->recentActivity = $bookings->toArray();
    }

    public function viewActivity($id)
    {
        return redirect()->route('admin.bookings');
    }

    public function render()
    {
        $availablePct = $this->totalCars > 0 ? round((Car::where('status', 'available')->count() / $this->totalCars) * 100) : 0;
        $maintenancePct = $this->totalCars > 0 ? round((Car::where('status', 'maintenance')->count() / $this->totalCars) * 100) : 0;
        $inspectionPct = $this->totalCars > 0 ? round((Car::where('status', 'rented')->count() / $this->totalCars) * 100) : 0;

        return view('livewire.admin-control-center', compact('availablePct', 'maintenancePct', 'inspectionPct'));
    }
}
