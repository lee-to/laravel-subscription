<?php

namespace Leeto\Subscription\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionHistory extends Model
{
    use HasFactory;

    protected $fillable = ['plan_id', 'subscription_id', 'price', 'bank_card_id'];

    public function plan() {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function subscription() {
        return $this->belongsTo(Subscription::class);
    }

    public function bankCard() {
        return $this->belongsTo(SubscriptionBankCard::class);
    }
}
