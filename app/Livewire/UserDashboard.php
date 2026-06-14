<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Car;

class UserDashboard extends Component
{
    use WithPagination;

    public $tab = 'overview';
    public $messageSubject = '';
    public $messageBody = '';

    protected $listeners = ['licenseSaved' => '$refresh'];

    protected $rules = [
        'messageSubject' => 'required|string|max:255',
        'messageBody' => 'required|string|min:10',
    ];

    public function switchTab($tab)
    {
        $this->tab = $tab;
    }

    public function sendMessage()
    {
        $this->validate();

        ContactMessage::create([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'subject' => $this->messageSubject,
            'message' => $this->messageBody,
            'is_read' => false,
        ]);

        $this->messageSubject = '';
        $this->messageBody = '';
        session()->flash('message', 'تم إرسال رسالتك بنجاح. سنتواصل معك قريباً.');
    }

    public function render()
    {
        $user = auth()->user();
        $bookings = Booking::with('car')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);
        $totalBookings = Booking::where('user_id', $user->id)->count();
        $activeBookings = Booking::where('user_id', $user->id)
            ->whereIn('status', ['confirmed', 'active'])
            ->count();
        $completedBookings = Booking::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();
        $pendingBookings = Booking::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        $messages = ContactMessage::where('email', $user->email)
            ->latest()
            ->get();
        $availableCars = Car::where('status', 'available')->count();

        return view('livewire.user-dashboard', compact(
            'user', 'bookings', 'totalBookings', 'activeBookings',
            'completedBookings', 'pendingBookings', 'messages', 'availableCars'
        ));
    }
}
