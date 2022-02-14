<?php

namespace Leeto\Subscription\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SubscribedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $plan_id = null)
    {
        if(!$request->user() || !$request->user()->subscriptionHas($plan_id)) {
            if(config('subscription.unsubscribed_redirect')) {
                return redirect(config('subscription.unsubscribed_redirect'));
            }

            abort(403);
        }

        return $next($request);
    }
}
