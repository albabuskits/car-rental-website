<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Booking;
use App\Notifications\BookingStatusNotification;
use Illuminate\Support\Facades\Notification;

class AdminBookings extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $editingBooking = null;
    public $showEditModal = false;

    public $customer_name = '';
    public $customer_email = '';
    public $customer_phone = '';
    public $pickup_date = '';
    public $return_date = '';
    public $total_price = '';
    public $status = 'pending';

    protected $rules = [
        'customer_name' => 'required|string|max:255',
        'customer_email' => 'required|email|max:255',
        'customer_phone' => 'nullable|string|max:20',
        'pickup_date' => 'required|date',
        'return_date' => 'required|date|after:pickup_date',
        'total_price' => 'required|numeric|min:0',
        'status' => 'required|in:pending,confirmed,active,completed,cancelled',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function openEditModal($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        if (in_array($booking->status, ['completed', 'cancelled'])) {
            $msg = $booking->status === 'completed' ? 'لا يمكن تعديل حجز مكتمل.' : 'لا يمكن تعديل حجز ملغي.';
            session()->flash('message', $msg);
            return;
        }
        $this->editingBooking = $booking;
        $this->customer_name = $booking->customer_name;
        $this->customer_email = $booking->customer_email;
        $this->customer_phone = $booking->customer_phone;
        $this->pickup_date = $booking->pickup_date->format('Y-m-d\TH:i');
        $this->return_date = $booking->return_date->format('Y-m-d\TH:i');
        $this->total_price = $booking->total_price;
        $this->status = $booking->status;
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editingBooking = null;
    }

    public function updateBooking()
    {
        $this->validate();

        if ($this->editingBooking) {
            if (in_array($this->editingBooking->status, ['completed', 'cancelled'])) {
                $msg = $this->editingBooking->status === 'completed' ? 'لا يمكن تعديل حجز مكتمل.' : 'لا يمكن تعديل حجز ملغي.';
                session()->flash('message', $msg);
                $this->closeEditModal();
                return;
            }
            $oldStatus = $this->editingBooking->status;
            $this->editingBooking->update([
                'customer_name' => $this->customer_name,
                'customer_email' => $this->customer_email,
                'customer_phone' => $this->customer_phone,
                'pickup_date' => $this->pickup_date,
                'return_date' => $this->return_date,
                'total_price' => $this->total_price,
                'status' => $this->status,
            ]);
            if ($this->customer_email && $oldStatus !== $this->status) {
                Notification::route('mail', $this->customer_email)
                    ->notify(new BookingStatusNotification(
                        $this->editingBooking, $oldStatus, $this->status
                    ));
            }
            session()->flash('message', 'تم تحديث الحجز بنجاح.');
        }

        $this->closeEditModal();
    }

    public function updateStatus($bookingId, $newStatus)
    {
        $booking = Booking::with('car')->findOrFail($bookingId);
        if (in_array($booking->status, ['completed', 'cancelled'])) {
            $msg = $booking->status === 'completed' ? 'لا يمكن تغيير حالة الحجز المكتمل.' : 'لا يمكن تغيير حالة الحجز الملغي.';
            session()->flash('message', $msg);
            return;
        }
        $oldStatus = $booking->status;
        $booking->update(['status' => $newStatus]);
        if ($booking->customer_email && $oldStatus !== $newStatus) {
            Notification::route('mail', $booking->customer_email)
                ->notify(new BookingStatusNotification(
                    $booking, $oldStatus, $newStatus
                ));
        }
        session()->flash('message', 'تم تحديث حالة الحجز بنجاح.');
    }

    public function render()
    {
        if ($this->search) {
            try {
                $bookings = Booking::search($this->search)
                    ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
                    ->query(fn($q) => $q->with(['car', 'user']))
                    ->paginate(10);
            } catch (\Meilisearch\Exceptions\CommunicationException $e) {
                $bookings = Booking::with(['car', 'user'])
                    ->where(function ($q) {
                        $q->where('customer_name', 'like', '%' . $this->search . '%')
                          ->orWhere('customer_email', 'like', '%' . $this->search . '%')
                          ->orWhereHas('car', function ($cq) {
                              $cq->where('brand', 'like', '%' . $this->search . '%')
                                 ->orWhere('model', 'like', '%' . $this->search . '%');
                          });
                    })
                    ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
                    ->latest()->paginate(10);
            }
        } else {
            $query = Booking::with(['car', 'user']);

            if ($this->statusFilter) {
                $query->where('status', $this->statusFilter);
            }

            $bookings = $query->latest()->paginate(10);
        }

        $pendingCount = Booking::where('status', 'pending')->count();
        $confirmedToday = Booking::where('status', 'confirmed')
            ->whereDate('created_at', today())
            ->count();
        $totalBookings = Booking::count();

        return view('livewire.admin-bookings', compact('bookings', 'pendingCount', 'confirmedToday', 'totalBookings'));
    }
}
