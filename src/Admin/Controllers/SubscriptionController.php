<?php

namespace Leeto\Subscription\Admin\Controllers;

use Leeto\Admin\Controllers\Controller;
use Leeto\Admin\Traits\ControllerTrait;
use Leeto\Subscription\Admin\Resources\SubscriptionResource;

class SubscriptionController extends Controller
{
    use ControllerTrait;

    public function __construct()
    {
        $this->resource = new SubscriptionResource();
    }
}
