<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');

            if (config('app.url') === 'http://localhost' && request()->isSecure()) {
                config(['app.url' => 'https://' . request()->getHost()]);
            }
        }
    }
}
