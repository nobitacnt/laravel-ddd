<?php

namespace Modules\Shared\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $migrations = [];
        $domainPath = base_path('modules');
        $files = glob($domainPath . '/*/' . 'Infrastructure/Migrations/*');

        foreach ($files as $file) {
            $migrations[] = $file;
        }

        $this->loadMigrationsFrom($migrations);
    }
}
