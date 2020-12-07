<?php

namespace Leeto\Subscription\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionItemHistory extends Model
{
    use HasFactory;

    protected $fillable = ['subscription_item_id', 'price', 'bank_card_id'];

    public function subscriptionItem() {
        return $this->belongsTo(SubscriptionItem::class);
    }

    public function bankCard() {
        return $this->belongsTo(SubscriptionBankCard::class);
    }

    public function histories() {
        return $this->hasMany(SubscriptionItemHistory::class);
    }
}
