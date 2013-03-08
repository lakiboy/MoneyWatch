<?php

namespace MoneyWatch\Provider;

use MoneyWatch\Manager\SubscriptionManager;
use MoneyWatch\Manager\CurrencyManager;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Register MoneyWatch managers.
 */
class ManagerServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['currency_manager'] = $app->share(function ($app) {
            return new CurrencyManager($app['db']);
        });
        $app['subscription_manager'] = $app->share(function ($app) {
            return new SubscriptionManager($app['db']);
        });
    }

    public function boot(Application $app)
    {
    }
}
