<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Log;

class NotificationBell extends Component
{
    public $unreadCount = 0;
    public $showDropdown = false;
    public $notifications = [];

    protected $listeners = ['refreshNotifications' => 'loadNotifications'];

    public function mount()
    {
        try {
            $this->loadNotifications();
        } catch (\Exception $e) {
            $this->notifications = [];
            $this->unreadCount = 0;
        }
    }

    public function loadNotifications()
    {
        $user = auth()->user();
        $lastRead = $user->last_read_activities_at;

        if ($user->hasRole('admin')) {
            $query = Booking::with('car')->where('status', 'pending');

            $bookings = (clone $query)
                ->latest()
                ->take(5)
                ->get();

            $this->notifications = $bookings->map(fn($b) => [
                'id' => $b->id,
                'icon' => 'assignment',
                'icon_color' => 'text-amber-500',
                'description' => 'حجز جديد من ' . ($b->customer_name ?? '-') . ' لسيارة ' . ($b->car?->brand ?? '') . ' ' . ($b->car?->model ?? ''),
                'time' => $b->created_at->diffForHumans(),
                'type' => 'booking_request',
                'url' => route('admin.bookings'),
            ])->values()->toArray();

            $this->unreadCount = $lastRead
                ? (clone $query)->where('created_at', '>', $lastRead)->count()
                : (clone $query)->count();
        } else {
            $query = Booking::with('car')
                ->where('user_id', $user->id)
                ->where('status', '!=', 'pending');

            $bookings = (clone $query)
                ->latest('updated_at')
                ->take(5)
                ->get();

            $this->notifications = $bookings->map(fn($b) => [
                'id' => $b->id,
                'icon' => $b->status === 'confirmed' ? 'check_circle' : ($b->status === 'cancelled' ? 'cancel' : 'info'),
                'icon_color' => $b->status === 'confirmed' ? 'text-green-500' : ($b->status === 'cancelled' ? 'text-red-500' : 'text-blue-500'),
                'description' => 'تم ' . (
                    $b->status === 'confirmed' ? 'الموافقة على' :
                    ($b->status === 'cancelled' ? 'إلغاء' : 'تحديث حالة')
                ) . ' حجزك للسيارة ' . ($b->car?->brand ?? '') . ' ' . ($b->car?->model ?? ''),
                'time' => $b->updated_at->diffForHumans(),
                'type' => 'booking_status',
                'url' => '/dashboard',
            ])->values()->toArray();

            $query = Booking::where('user_id', $user->id)->where('status', '!=', 'pending');
            $this->unreadCount = $lastRead
                ? (clone $query)->where('updated_at', '>', $lastRead)->count()
                : (clone $query)->count();
        }
    }

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
    }

    public function markAsRead()
    {
        $user = auth()->user();
        $user->last_read_activities_at = now();
        $user->save();
        $this->unreadCount = 0;
    }

    public function dismiss($logId)
    {
        $this->markAsRead();
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}
