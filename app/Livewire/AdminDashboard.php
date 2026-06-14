<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Car;
use App\Models\Booking;
use App\Models\User;

class AdminDashboard extends Component
{
    public $totalCars = 0;
    public $activeBookings = 0;
    public $totalUsers = 0;
    public $monthlyRevenue = 0;
    public $recentBookings = [];
    public $availableCars = 0;
    public $maintenanceCars = 0;
    public $inspectionCars = 0;

    public function mount()
    {
        $this->totalCars = Car::count();
        $this->activeBookings = Booking::whereIn('status', ['confirmed', 'active'])->count();
        $this->totalUsers = User::count();
        $this->monthlyRevenue = Booking::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');

        $this->recentBookings = Booking::with(['car', 'user'])
            ->latest()
            ->take(5)
            ->get()
            ->toArray();

        $total = $this->totalCars > 0 ? $this->totalCars : 1;
        $this->availableCars = Car::where('status', 'available')->count();
        $this->maintenanceCars = Car::where('status', 'maintenance')->count();
        $this->inspectionCars = Car::where('status', 'rented')->count();
    }

    public function viewBooking($id)
    {
        return redirect()->route('admin.bookings');
    }

    public function cancelBooking($id)
    {
        $booking = Booking::find($id);
        if ($booking && $booking->status === 'pending') {
            $booking->update(['status' => 'cancelled']);
            $this->mount();
            session()->flash('message', 'تم إلغاء الحجز بنجاح.');
        }
    }

    public function render()
    {
        return view('livewire.admin-dashboard');
    }
}
