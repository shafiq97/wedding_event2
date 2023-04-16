<?php

namespace App\Listeners;

use App\Events\BookingCompleted;
use App\Notifications\BookingConfirmation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendBookingConfirmation implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param BookingCompleted $service
     *
     * @return void
     */
    public function handle(BookingCompleted $service)
    {
        $notification = Notification::route('mail', $service->booking->email);
        if (isset($service->booking->bookedByUser) && $service->booking->bookedByUser->email !== $service->booking->email) {
            $notification->route('mail', $service->booking->bookedByUser->email);
        }
        $notification->notify(
            new BookingConfirmation($service->booking)
        );
        Log::info(
            sprintf(
                'Sent mail notification for booking %s to %s and %s',
                $service->booking->id,
                $service->booking->email,
                $service->booking->bookedByUser->email ?? '-'
            )
        );
    }
}
