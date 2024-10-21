<?php

namespace Modules\Product\Infrastructure\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Modules\Product\Application\Listeners\StoreProductListener;
use Modules\Product\Domain\Events\StoreProductEvent;
use Modules\Product\Domain\Repositories\IProductRepository;
use Modules\Product\Domain\Rules\CodeUniqueRule;
use Modules\Product\Infrastructure\Repositories\ProductRepository;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(
            IProductRepository::class,
            ProductRepository::class
        );

        // Rule injection
        $this->app->singleton(CodeUniqueRule::class, function ($app) {
            return new CodeUniqueRule($app->make(IProductRepository::class));
        });
    }

    public function boot()
    {
        // Register event listeners
        Event::listen(
            StoreProductEvent::class,
            StoreProductListener::class
        );
    }
}
