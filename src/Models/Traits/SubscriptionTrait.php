<?php

namespace Leeto\Subscription\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait SubscriptionTrait
{
    public function scopeActive(Builder $query)
    {
        return $query->whereDate('ends_at', '>', now())->orWhere('unlimited', '=', true);
    }

    public function scopePayToday(Builder $query)
    {
        return $query->whereDate('ends_at', '=', now())->where('unlimited', '=', false);
    }

    public function user() {
        return $this->belongsTo(config("subscription.class_user"));
    }
}