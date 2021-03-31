<?php

namespace Leeto\Subscription\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Leeto\Subscription\Models\Subscription;

class SubscriptionUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The subscription instance.
     *
     * @var \Leeto\Subscription\Models\Subscription
     */
    public $subscription;

    /**
     * Create a new event instance.
     *
     * @param  \Leeto\Subscription\Models\Subscription $subscription
     * @return void
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }
}