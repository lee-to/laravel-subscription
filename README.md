# laravel-subscription

## Install
- composer require lee-to/laravel-subscription

- php artisan vendor:publish --provider="Leeto\Subscription\Providers\SubscriptionServiceProvider"
- php artisan subscription:make plan
- set config\subscription default plan id
- add Leeto\Subscription\Traits\Subscription trait to user model
- add Leeto\Subscription\Traits\SubscriptionItem trait to subscription item model

## Use
- $user->subscriptions() get all user subscriptions
- $user->subscriptionItems() get all user subscription items
- $user->bankCards() get all user bank cards

- $user->addBankCard($recurring_payment_id, $first_4, $last_4, $month, $year, $type = null, $default = true)
- $user->deleteBankCard($id) - delete
- $user->defaultBankCard($id) set default

- $user->makeSubscription($plan_id, $unlimited = true, $ends_at = null, $bank_card_id = null) create or update subscription
- $user->makeSubscriptionItem(Model $model, $unlimited = true, $ends_at = null, $bank_card_id = null, $customPrice = null) create or update subscription item
- $user->subscriptionEnd($plan_id = null, $format = "Y-m-d") end date
- $user->subscriptionHas($plan_id = null) check has 
- $user->subscriptionHasItem(Model $model) check has 

- User::query()->subscribed()->get() subscribed scope
- User::query()->unsubscribed()->get() unsubscribed scope
- User::query()->payToday()->get() payToday scope
- 
### Facade
- Subscription::getPlanPrice($plan_id) - get plan price
- subscription()->getPlans() || Subscription::getPlans() get all plans \Illuminate\Database\Eloquent\Builder
- subscription()->getSubscriptions() || Subscription::getSubscriptions() get all subscriptions \Illuminate\Database\Eloquent\Builder
- subscription()->getSubscriptionItems() || Subscription::getSubscriptionItems() get all subscription items \Illuminate\Database\Eloquent\Builder

- subscription()->getSubscriptionsPayToday() || Subscription::getSubscriptionsPayToday() today payment rows
- subscription()->getSubscriptionItemsPayToday() || Subscription::getSubscriptionItemsPayToday() today payment rows

### Middleware

- \Leeto\Subscription\Http\Middleware\SubscribedMiddleware

### Events

- \Leeto\Subscription\Events\SubscriptionCreated
- \Leeto\Subscription\Events\SubscriptionUpdated

- \Leeto\Subscription\Events\SubscriptionItemCreated
- \Leeto\Subscription\Events\SubscriptionItemUpdated

## Integration with laravel-admin
- set admin path in admin config 
- add to admin route Route::resource('subscriptions', \Leeto\Subscription\Admin\Controllers\SubscriptionController::class);
- add to admin menu ["class" =>\Leeto\Subscription\Admin\Controllers\SubscriptionController::class, "title" => "Subscription"],