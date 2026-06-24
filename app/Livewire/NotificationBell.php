<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;
use App\Models\DriverLicense;
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
        $notifications = collect();

        if ($user->hasRole('admin')) {
            Booking::with('car')->where('status', 'pending')->latest()->take(5)->get()->each(function ($b) use ($notifications) {
                $notifications->push([
                    'id' => $b->id,
                    'icon' => 'assignment',
                    'icon_color' => 'text-amber-500',
                    'description' => 'حجز جديد من ' . ($b->customer_name ?? '-') . ' لسيارة ' . ($b->car?->brand ?? '') . ' ' . ($b->car?->model ?? ''),
                    'time' => $b->created_at->diffForHumans(),
                    'created_at' => $b->created_at,
                    'type' => 'booking_request',
                    'url' => route('admin.bookings'),
                ]);
            });

            DriverLicense::with('user')->where('status', 'pending')->latest()->take(5)->get()->each(function ($l) use ($notifications) {
                $notifications->push([
                    'id' => $l->id,
                    'icon' => 'badge',
                    'icon_color' => 'text-purple-500',
                    'description' => 'طلب توثيق رخصة من ' . ($l->full_name ?? $l->user?->name ?? '-'),
                    'time' => $l->created_at->diffForHumans(),
                    'created_at' => $l->created_at,
                    'type' => 'license_request',
                    'url' => route('admin.licenses'),
                ]);
            });

            $this->notifications = $notifications->sortByDesc('created_at')->take(5)->values()->toArray();

            $bookingUnread = Booking::where('status', 'pending')
                ->when($lastRead, fn($q) => $q->where('created_at', '>', $lastRead))
                ->count();
            $licenseUnread = DriverLicense::where('status', 'pending')
                ->when($lastRead, fn($q) => $q->where('created_at', '>', $lastRead))
                ->count();
            $this->unreadCount = $bookingUnread + $licenseUnread;
        } else {
            Booking::with('car')
                ->where('user_id', $user->id)
                ->where('status', '!=', 'pending')
                ->latest('updated_at')
                ->take(5)
                ->get()
                ->each(function ($b) use ($notifications) {
                    $notifications->push([
                        'id' => $b->id,
                        'icon' => $b->status === 'confirmed' ? 'check_circle' : ($b->status === 'cancelled' ? 'cancel' : 'info'),
                        'icon_color' => $b->status === 'confirmed' ? 'text-green-500' : ($b->status === 'cancelled' ? 'text-red-500' : 'text-blue-500'),
                        'description' => 'تم ' . (
                            $b->status === 'confirmed' ? 'الموافقة على' :
                            ($b->status === 'cancelled' ? 'إلغاء' : 'تحديث حالة')
                        ) . ' حجزك للسيارة ' . ($b->car?->brand ?? '') . ' ' . ($b->car?->model ?? ''),
                        'time' => $b->updated_at->diffForHumans(),
                        'created_at' => $b->updated_at,
                        'type' => 'booking_status',
                        'url' => '/dashboard',
                    ]);
                });

            $myLicense = DriverLicense::where('user_id', $user->id)->where('status', '!=', 'pending')->first();
            if ($myLicense) {
                $notifications->push([
                    'id' => $myLicense->id,
                    'icon' => $myLicense->status === 'verified' ? 'verified' : 'gpp_bad',
                    'icon_color' => $myLicense->status === 'verified' ? 'text-green-500' : 'text-red-500',
                    'description' => $myLicense->status === 'verified'
                        ? 'تم توثيق رخصة القيادة الخاصة بك.'
                        : 'تم رفض رخصة القيادة الخاصة بك.',
                    'time' => $myLicense->updated_at->diffForHumans(),
                    'created_at' => $myLicense->updated_at,
                    'type' => 'license_status',
                    'url' => '/dashboard',
                ]);
            }

            $this->notifications = $notifications->sortByDesc('created_at')->take(5)->values()->toArray();

            $bookingUnread = Booking::where('user_id', $user->id)->where('status', '!=', 'pending')
                ->when($lastRead, fn($q) => $q->where('updated_at', '>', $lastRead))
                ->count();
            $licenseUnread = 0;
            if ($myLicense) {
                $licenseUnread = $lastRead
                    ? ($myLicense->updated_at > $lastRead ? 1 : 0)
                    : 1;
            }
            $this->unreadCount = $bookingUnread + $licenseUnread;
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
