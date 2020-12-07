<?php

namespace Leeto\Subscription;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Leeto\Subscription\SubscriptionManager
 */
class Subscription extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'subscription';
    }
}
