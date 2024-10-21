<?php

namespace Modules\User\Infrastructure\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Modules\User\Application\Listeners\StoreUserListener;
use Modules\User\Domain\Events\StoreUserEvent;
use Modules\User\Domain\Repositories\IUserRepository;
use Modules\User\Domain\Rules\EmailUniqueRule;
use Modules\User\Infrastructure\Repositories\UserRepository;

class UserServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(
            IUserRepository::class,
            UserRepository::class
        );

        // Rule injection
        $this->app->singleton(EmailUniqueRule::class, function ($app) {
            return new EmailUniqueRule($app->make(IUserRepository::class));
        });
    }

    public function boot()
    {
        // Register event listeners
        Event::listen(
            StoreUserEvent::class,
            StoreUserListener::class
        );
    }
}
