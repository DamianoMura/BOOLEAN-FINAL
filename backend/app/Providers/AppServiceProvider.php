<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;


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
        Schema::defaultStringLength(191);

        //direttiva @admin @endadmin for visible sections and links
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->isAdmin();
        });
        //direttiva @dev @enddev for visible sections and links
        Blade::if('dev', function () {
            return auth()->check() && auth()->user()->isDev();
        });

        //mixed permissions


    }
}
