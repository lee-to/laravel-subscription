<?php

namespace Leeto\Subscription\Admin\Resources;

use Leeto\Admin\Components\Fields\Date;
use Leeto\Admin\Components\Fields\HasOne;
use Leeto\Admin\Components\Fields\ID;
use Leeto\Admin\Components\Fields\SwitchField;
use Leeto\Admin\Components\Filters\DateRangeFilter;
use Leeto\Admin\Components\Filters\HasOneFilter;
use Leeto\Admin\Components\Filters\SwitchFilter;

use Leeto\Admin\Resources\Resource;
use Leeto\Subscription\Models\Subscription;


class SubscriptionResource extends Resource
{
	public static $model = Subscription::class;

	public $title = "Subscription";

	public function fields()
	{
		return [
            ID::make("id")->sortable(),
            HasOne::make("user_id", "user", "name"),
            HasOne::make("plan_id", "plan", "name"),
            SwitchField::make("unlimited")->default(0),
            Date::make("ends_at")->required(),
        ];
	}

	public function rules($item) {
	    return [
            "user_id" => "required",
            "plan_id" => "required",
            "ends_at" => "required",
	    ];
    }

    public function search()
    {
        return ["id", "user_id"];
    }

    public function filters()
    {
        return [
            HasOneFilter::make("user_id", "user", "name"),
            HasOneFilter::make("plan_id", "plan", "name"),
            SwitchFilter::make("unlimited"),
            DateRangeFilter::make("ends_at")
        ];
    }

	public function attributes() {
	    return [
            "id" => "ID",
            "user_id" => "User",
            "plan_id" => "Plan",
            "unlimited" => "Unlimited",
            "ends_at" => "Ends at",
        ];
    }
}
