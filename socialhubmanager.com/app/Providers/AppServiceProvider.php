<?php

namespace App\Providers;

use App\Services\TwoFactorService;
use PragmaRX\Google2FAQRCode\Google2FA;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // TODO: Create custom Service Provider
        $this->app->singleton(TwoFactorService::class, function ($app) {
            return new TwoFactorService(new Google2Fa());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
