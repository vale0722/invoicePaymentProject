<?php

namespace App\Listeners;

use App\Events\LogPaymentEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogPaymentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(LogPaymentEvent $event)
    {
        if ($event->type == 'info') {
            Log::info($event->message, [
            'payment' => $event->payment,
            'invoice' => $event->invoice,
            'ipAddress' => $event->ip,
            'userAgent' => $event->userAgent
        ]);
        }
        if ($event->type == 'error') {
            Log::error($event->message, [
                'payment' => $event->payment,
                'invoice' => $event->invoice,
                'ipAddress' => $event->ip,
                'userAgent' => $event->userAgent
            ]);
        }
        if ($event->type == 'alert') {
            Log::alert($event->message, [
                'payment' => $event->payment,
                'invoice' => $event->invoice,
                'ipAddress' => $event->ip,
                'userAgent' => $event->userAgent
            ]);
        }
    }
}
