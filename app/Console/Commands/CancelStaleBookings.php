<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CancelStaleBookings extends Command
{
    protected $signature = 'bookings:cancel-stale
        {--hours=24 : Number of hours after which a pending booking is considered stale}';

    protected $description = 'Cancel pending bookings that have not been confirmed within the specified hours';

    public function handle()
    {
        $hours = (int) $this->option('hours');
        $cutoff = Carbon::now()->subHours($hours);

        $count = Booking::where('status', 'pending')
            ->where('created_at', '<=', $cutoff)
            ->update(['status' => 'cancelled']);

        $this->info("Cancelled {$count} stale pending booking(s).");

        return Command::SUCCESS;
    }
}
