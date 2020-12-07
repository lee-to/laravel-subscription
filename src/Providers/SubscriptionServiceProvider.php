<?php

namespace Leeto\Subscription\Providers;

use Illuminate\Support\ServiceProvider;
use Leeto\Subscription\Commands\MakeCommand;
use Leeto\Subscription\SubscriptionManager;

class SubscriptionServiceProvider extends ServiceProvider
{
    protected $namespace = "subscription";

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('subscription', SubscriptionManager::class);

        $this->registerCommands();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $path = __DIR__ . "/..";

        /* Config */
        $this->publishes([
            $path . '/config/subscription.php' => config_path($this->namespace . '.php'),
        ]);

        /* Migrations */
        $this->loadMigrationsFrom($path . '/database/migrations');
    }

    protected function registerCommands()
    {
        /* Commands */
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeCommand::class
            ]);
        }
    }

}
