<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Car;
use App\Models\Booking;
use App\Models\User;
use App\Models\ActivityLog;

class AdminDashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $totalCars = 0;
    public $activeBookings = 0;
    public $totalUsers = 0;
    public $monthlyRevenue = 0;
    public $recentBookings = [];
    public $availableCars = 0;
    public $maintenanceCars = 0;
    public $inspectionCars = 0;
    public $recentActivities = [];
    public $todayActivityCount = 0;

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

        $this->recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->toArray();

        $this->todayActivityCount = ActivityLog::whereDate('created_at', today())->count();
    }

    public function updatedSearch()
    {
        $this->resetPage();
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
        if ($this->search) {
            try {
                $recentBookings = Booking::search($this->search)
                    ->query(fn($q) => $q->with(['car', 'user'])->latest()->take(5))
                    ->get()
                    ->toArray();
            } catch (\Meilisearch\Exceptions\CommunicationException $e) {
                $recentBookings = Booking::with(['car', 'user'])
                    ->where(function ($q) {
                        $q->where('customer_name', 'like', '%' . $this->search . '%')
                          ->orWhereHas('car', fn($cq) => $cq->where('brand', 'like', '%' . $this->search . '%')
                             ->orWhere('model', 'like', '%' . $this->search . '%'));
                    })
                    ->latest()->take(5)->get()->toArray();
            }
        } else {
            $recentBookings = $this->recentBookings;
        }

        return view('livewire.admin-dashboard', ['recentBookings' => $recentBookings]);
    }
}
