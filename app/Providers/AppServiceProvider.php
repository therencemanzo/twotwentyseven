<?php

namespace App\Providers;

use App\Services\VatService;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // // Share geo-IP data with all views
        // View::composer('*', function ($view) {
        //     $geoIpData = app('geoIpData');
        //     $view->with('geoIpData', $geoIpData);
        // });
    }
}
