<?php

namespace App\Listeners;

use App\Events\LogInvoiceEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogInvoiceListener
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
    public function handle(LogInvoiceEvent $event)
    {
        if ($event->type == 'info') {
            Log::info($event->message, [
            'invoice' => $event->invoice,
            'ipAddress' => $event->ip,
            'userAgent' => $event->userAgent
        ]);
        }
        if ($event->type == 'error') {
            Log::error($event->message, [
                'invoice' => $event->invoice,
                'ipAddress' => $event->ip,
                'userAgent' => $event->userAgent
            ]);
        }
        if ($event->type == 'alert') {
            Log::alert($event->message, [
                'invoice' => $event->invoice,
                'ipAddress' => $event->ip,
                'userAgent' => $event->userAgent
            ]);
        }
    }
}