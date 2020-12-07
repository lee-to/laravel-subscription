<?php

namespace Leeto\Subscription;

use Leeto\Subscription\Models\Subscription;
use Leeto\Subscription\Models\SubscriptionItem;
use Leeto\Subscription\Models\SubscriptionPlan;

/**
 * Class SubscriptionManager
 * @package Leeto\Subscription
 */
class SubscriptionManager
{
    /**
     * @param array $with
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getPlans($with = []) {
        return SubscriptionPlan::query()->with($with);
    }

    /**
     * @param array $with
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getSubscriptions($with = []) {
        return Subscription::query()->with($with);
    }

    /**
     * @param array $with
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getSubscriptionItems($with = []) {
        return SubscriptionItem::query()->with($with);
    }

    public function getSubscriptionsPayToday() {
        return $this->getSubscriptions()->payToday()->get();
    }

    public function getSubscriptionItemsPayToday() {
        return $this->getSubscriptionItems()->payToday()->get();
    }
}
