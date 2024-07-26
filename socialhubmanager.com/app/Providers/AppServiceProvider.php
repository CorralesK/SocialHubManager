<?php

namespace App\Providers;

use App\Services\TwoFactorService;
use PragmaRX\Google2FAQRCode\Google2FA;
use Illuminate\Support\ServiceProvider;

use App\Services\TwitterService;
use App\Services\SocialService;
use App\Services\DefaultService;

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
        
        $this->app->singleton(SocialService::class, function ($app) {
            $provider = request()->route('provider');

            if (!$provider) {
                return new DefaultService();
            }

            switch ($provider) {
                case 'twitter':
                    return new TwitterService();
                // Otros casos según sea necesario
                default:
                    throw new \Exception("Unsupported provider: {$provider}");
            }
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
