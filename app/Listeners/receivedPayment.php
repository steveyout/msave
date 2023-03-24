<?php

namespace App\Listeners;

use App\Events\payment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class receivedPayment
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
     * @param  payment  $event
     * @return payment
     */
    public function handle(payment $event)
    {
        //
        return $event;

    }
}
