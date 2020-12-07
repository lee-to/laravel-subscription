<?php

namespace Leeto\Subscription;

if (!function_exists('subscription')) {
    /**
     * Get the subscription instance.
     *
     * @return \Leeto\Subscription\SubscriptionManager
     */
    function subscription()
    {
        return app("subscription");
    }
}