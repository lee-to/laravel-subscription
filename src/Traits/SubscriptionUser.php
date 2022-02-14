<?php
namespace Leeto\Subscription\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Str;
use Leeto\Subscription\Events\SubscriptionCreated;
use Leeto\Subscription\Events\SubscriptionItemCreated;
use Leeto\Subscription\Events\SubscriptionItemUpdated;
use Leeto\Subscription\Events\SubscriptionUpdated;
use Leeto\Subscription\Models\Subscription;
use Leeto\Subscription\Models\SubscriptionBankCard;
use Leeto\Subscription\Models\SubscriptionHistory;
use Leeto\Subscription\Models\SubscriptionItem;
use Leeto\Subscription\Models\SubscriptionItemHistory;

trait SubscriptionUser
{
    /* Relationships */

    /**
     * Get the entity's subscriptions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get the entity's subscriptionItems.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function subscriptionItems()
    {
        return $this->morphMany(SubscriptionItem::class, 'modelable');
    }

    /**
     * Get the entity's bank cards.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function bankCards()
    {
        return $this->hasMany(SubscriptionBankCard::class);
    }


    public function addBankCard($recurring_payment_id, $first_4, $last_4, $month, $year, $type = null, $default = true) {
        $first_4 = Str::limit($first_4, 4);
        $last_4 = Str::limit($last_4, 4);

        if($default) {
            $this->bankCards()->update(["default" => false]);
        }

        return $this->bankCards()->create(
            compact('recurring_payment_id', 'first_4', 'last_4', 'type', 'month', 'year', 'default')
        );
    }

    public function deleteBankCard($id) {
        return boolval($this->bankCards()->where(["id" => $id])->delete());
    }

    public function defaultBankCard($id) {
        $this->bankCards()->update(["default" => false]);

        return boolval($this->bankCards()->where(["id" => $id])->update(["default" => true]));
    }

    public function changeSubscriptionPlan($id, $plan_id) {
        return boolval($this->subscriptions()->where(["id" => $id])->update(["plan_id" => $plan_id]));
    }

    public function makeSubscription($plan_id = null, $unlimited = true, $ends_at = null, $bank_card_id = null) {
        if(is_null($plan_id)) {
            $plan_id = config("subscription.default_plan_id");
        }

        $data = [
            "plan_id" => $plan_id,
            "unlimited" => $unlimited,
            "ends_at" => $ends_at,
        ];

        if($subscription = $this->subscriptions()->where(["plan_id" => $plan_id])->first()) {
            $subscription->update($data);

            event(new SubscriptionUpdated($subscription));
        } else {
            $subscription = $this->subscriptions()->create($data);

            event(new SubscriptionCreated($subscription));
        }

        if($subscription) {
            SubscriptionHistory::create([
                "subscription_id" => $subscription->id,
                "plan_id" => $subscription->plan_id,
                "price" => $subscription->plan->price,
                "bank_card_id" => $bank_card_id
            ]);
        }


        return $subscription;
    }

    public function makeSubscriptionItem(Model $model, $unlimited = true, $ends_at = null, $bank_card_id = null) {
        if($subscription = $model->subscriptionItems()->where(["user_id" => $this->id])->first()) {
            $subscription->update([
                "unlimited" => $unlimited,
                "ends_at" => $ends_at,
            ]);

            event(new SubscriptionItemUpdated($subscription));
        } else {
            $subscription = $model->subscriptionItems()->create([
                "user_id" => $this->id,
                "unlimited" => $unlimited,
                "ends_at" => $ends_at,
            ]);

            event(new SubscriptionItemCreated($subscription));
        }

        if($subscription) {
            SubscriptionItemHistory::create([
                "subscription_item_id" => $subscription->id,
                "price" => $model->price,
                "bank_card_id" => $bank_card_id
            ]);
        }


        return $subscription;
    }

    public function subscriptionEnd($plan_id = null, $format = "Y-m-d") {
        if(is_null($plan_id)) {
            $plan_id = config("subscription.default_plan_id");
        }

        $subscription = $this->subscriptions()->active()->where(["plan_id" => $plan_id])->first();

        return $subscription ? $subscription->ends_at->format($format) : false;
    }

    public function subscriptionHas($plan_id = null) {
        if(is_null($plan_id)) {
            $plan_id = config("subscription.default_plan_id");
        }

        return boolval($this->subscriptions()->active()->where(["plan_id" => $plan_id])->count());
    }

    public function subscriptionHasItem(Model $model) {
        $user_id = $this->id;

        return boolval($model->subscriptionItems()->whereHasMorph('modelable', $model->getMorphClass(), function (Builder $query) use ($user_id) {
            $query->where('user_id', '=', $user_id)
                ->where(function (Builder $query) {
                    $query->whereDate('ends_at', '>', now());
                    $query->orWhere('unlimited', '=', true);
                });
        })->count());
    }
}