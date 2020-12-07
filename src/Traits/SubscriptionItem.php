<?php
namespace Leeto\Subscription\Traits;

use Leeto\Subscription\Models\SubscriptionItem as SubItem;

trait SubscriptionItem
{
    /**
     * Get all of the post's comments.
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function subscriptionItems()
    {
        return $this->morphMany(SubItem::class, 'modelable');
    }
}