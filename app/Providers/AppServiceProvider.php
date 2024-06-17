<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Model;
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
    public function boot(UrlGenerator $url): void
    {
        Model::unguard();
        
        if (env('APP_ENV') == 'production') {
            $url->forceScheme('https');
        }
    }
}
