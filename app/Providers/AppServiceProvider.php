<?php

namespace App\Providers;

use App\Services\VatService;
use App\Tools\DeveloperTest;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(VatService::class, function ($app) {
            return VatService::getInstance(20);// Default VAT percentage is 20%
        });

        // Bind the Logger class as a singleton
        $this->app->singleton(DeveloperTest::class, function ($app) {
            return new DeveloperTest();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       
    }
}
