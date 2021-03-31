<?php

namespace Leeto\Subscription\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Leeto\Subscription\Models\SubscriptionItem;

class SubscriptionItemCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The subscriptionItem instance.
     *
     * @var \Leeto\Subscription\Models\SubscriptionItem
     */
    public $subscriptionItem;

    /**
     * Create a new event instance.
     *
     * @param  \Leeto\Subscription\Models\SubscriptionItem $subscription
     * @return void
     */
    public function __construct(SubscriptionItem $subscriptionItem)
    {
        $this->subscriptionItem = $subscriptionItem;
    }
}