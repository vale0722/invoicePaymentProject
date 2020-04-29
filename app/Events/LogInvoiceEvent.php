<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LogInvoiceEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $type;
    public $message;
    public $invoice;
    public $ip;
    public $userAgent;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $invoice, $ip, $userAgent, $type)
    {
        $this->message = $message;
        $this->invoice = $invoice;
        $this->ip = $ip;
        $this->userAgent = $userAgent;
        $this->type = $type;
    }
}
