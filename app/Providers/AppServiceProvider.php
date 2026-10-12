<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;

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
        View::addLocation(resource_path('views/user'));
        View::addLocation(resource_path('views/admin'));

        \Carbon\Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });
    }
}
