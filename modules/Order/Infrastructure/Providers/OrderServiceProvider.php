<?php

namespace Modules\Order\Infrastructure\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Modules\Order\Application\Listeners\StoreOrderListener;
use Modules\Order\Domain\Events\StoreOrderEvent;
use Modules\Order\Domain\Repositories\IOrderRepository;
use Modules\Order\Domain\Rules\CodeUniqueRule;
use Modules\Order\Infrastructure\Repositories\OrderRepository;

class OrderServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(
            IOrderRepository::class,
            OrderRepository::class
        );

        // Rule injection
        $this->app->singleton(CodeUniqueRule::class, function ($app) {
            return new CodeUniqueRule($app->make(IOrderRepository::class));
        });
    }

    public function boot()
    {
        // Register event listeners
        Event::listen(
            StoreOrderEvent::class,
            StoreOrderListener::class
        );
    }
}
