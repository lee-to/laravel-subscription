<?php

namespace Leeto\Subscription\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Leeto\Subscription\Models\Traits\SubscriptionTrait;

class Subscription extends Model
{
    use HasFactory, SubscriptionTrait;

    protected $fillable = ["user_id", "plan_id", "unlimited", "ends_at"];

    protected $dates = ["ends_at"];

    protected $casts = [
        "unlimited" => "boolean",
    ];

    public function plan() {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function histories() {
        return $this->hasMany(SubscriptionHistory::class);
    }
}
