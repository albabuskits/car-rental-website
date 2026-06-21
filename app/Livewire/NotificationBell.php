<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ActivityLog;

class NotificationBell extends Component
{
    public $unreadCount = 0;
    public $showDropdown = false;
    public $notifications = [];

    protected $listeners = ['refreshNotifications' => '$refresh'];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $user = auth()->user();
        $lastRead = $user->last_read_activities_at;

        $this->notifications = ActivityLog::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->toArray();

        if ($lastRead) {
            $this->unreadCount = ActivityLog::where('created_at', '>', $lastRead)->count();
        } else {
            $this->unreadCount = ActivityLog::count();
        }
    }

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
        if ($this->showDropdown) {
            $this->markAsRead();
        }
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
        // Dismissing marks all as read (keeps it simple - user doesn't want individual tracking)
        $this->markAsRead();
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}
