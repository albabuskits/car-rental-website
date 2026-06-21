<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BookingStatusNotification extends Notification
{
    use Queueable;

    public Booking $booking;
    public string $oldStatus;
    public string $newStatus;

    private array $statusLabels = [
        'pending' => 'معلق',
        'confirmed' => 'مؤكد',
        'active' => 'قيد التنفيذ',
        'completed' => 'مكتمل',
        'cancelled' => 'ملغي',
    ];

    public function __construct(Booking $booking, string $oldStatus, string $newStatus)
    {
        $this->booking = $booking;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $oldLabel = $this->statusLabels[$this->oldStatus] ?? $this->oldStatus;
        $newLabel = $this->statusLabels[$this->newStatus] ?? $this->newStatus;
        $car = $this->booking->car;

        return (new MailMessage)
            ->subject('تحديث حالة الحجز #' . $this->booking->id)
            ->greeting('مرحباً ' . $this->booking->customer_name)
            ->line('تم تحديث حالة حجزك في منصة تأجير السيارات.')
            ->line('رقم الحجز: #' . $this->booking->id)
            ->line('السيارة: ' . ($car ? $car->brand . ' ' . $car->model : '-'))
            ->line('تاريخ الاستلام: ' . $this->booking->pickup_date->format('Y-m-d'))
            ->line('تاريخ الإرجاع: ' . $this->booking->return_date->format('Y-m-d'))
            ->line('السعر الإجمالي: $' . number_format($this->booking->total_price, 2))
            ->line('الحالة السابقة: ' . $oldLabel)
            ->line('الحالة الجديدة: ' . $newLabel)
            ->line('للتواصل معنا، يرجى الاتصال على رقم الدعم أو الرد على هذا البريد الإلكتروني.')
            ->action('عرض التفاصيل', url('/dashboard'))
            ->salutation('مع تحيات فريق تأجير السيارات');
    }
}
