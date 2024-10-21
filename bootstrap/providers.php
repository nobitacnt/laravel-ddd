<?php
return [
    \Modules\Shared\Infrastructure\Providers\AppServiceProvider::class,
    \Modules\Shared\Infrastructure\Providers\RouteServiceProvider::class,
    \Modules\Shared\Infrastructure\Providers\AuthorizationServiceProvider::class,
    \Modules\User\Infrastructure\Providers\UserServiceProvider::class,
    \Modules\Order\Infrastructure\Providers\OrderServiceProvider::class,
    \Modules\Product\Infrastructure\Providers\ProductServiceProvider::class,
];
