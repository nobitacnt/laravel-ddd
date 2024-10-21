<?php

namespace Modules\Shared\Infrastructure\Providers;


use Illuminate\Support\ServiceProvider;
use Modules\Shared\Domain\Services\AuthorizationServiceInterface;
use Modules\Shared\Infrastructure\Services\AuthorizationService;

class AuthorizationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            AuthorizationServiceInterface::class,
            AuthorizationService::class
        );
    }
}
