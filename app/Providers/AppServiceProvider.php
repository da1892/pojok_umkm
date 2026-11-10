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

        // Otomatis hapus cache publik & admin ketika ada perubahan data
        \App\Models\User\Product::saved(fn() => \App\Services\CacheService::clearPublicCache());
        \App\Models\User\Product::deleted(fn() => \App\Services\CacheService::clearPublicCache());
        \App\Models\User\UmkmProfile::saved(fn() => \App\Services\CacheService::clearPublicCache());
        \App\Models\User\UmkmProfile::deleted(fn() => \App\Services\CacheService::clearPublicCache());
        \App\Models\User\NewsInformation::saved(fn() => \App\Services\CacheService::clearPublicCache());
        \App\Models\User\NewsInformation::deleted(fn() => \App\Services\CacheService::clearPublicCache());
    }
}
