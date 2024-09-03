<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

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
        //
        // if(config(`app.env`) === `local`){
        //     URL::forceScheme("https");
        // }
        // if(env("APP_ENV")!=="local"){
        //     URL::forceScheme("https");
        // }
        Route::aliasMiddleware('role', RoleMiddleware::class);

        if (app()->environment('local')) {
            URL::forceScheme('https');
        }
    }
}
