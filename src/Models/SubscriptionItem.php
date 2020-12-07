<?php

namespace Leeto\Subscription\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Leeto\Subscription\Models\Traits\SubscriptionTrait;

class SubscriptionItem extends Model
{
    use HasFactory, SubscriptionTrait;

    protected $fillable = ["user_id", "modelable_id", "modelable_type", "unlimited", "ends_at"];

    protected $casts = [
        "unlimited" => "boolean",
    ];

    protected $dates = ["ends_at"];

    /**
     * Get the owning modelable model.
     */
    public function modelable()
    {
        return $this->morphTo();
    }
}
