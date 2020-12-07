<?php

namespace Leeto\Subscription\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionBankCard extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "recurring_payment_id", "first_4", "last_4", "type", "month", "year", "default"];

    protected $casts = [
        "default" => "boolean",
    ];

    public function user() {
        return $this->belongsTo(config("subscription.class_user"));
    }
}
