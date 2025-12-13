<?php

namespace App\Providers;

use App\Listeners\SendWelcomeNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        if (config('app.env') != 'local') {
            URL::forceScheme('https');
        }

        Paginator::defaultView('vendor.pagination.tailwind');

        Event::listen(Registered::class, SendWelcomeNotification::class);
    }
}
