<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use App\Models\User;


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
        // Blade::if('components', function () {
        //     echo $components;
        // });

        //mixed permissions

        // Share demo users with all views for the user-switch dropdown
        View::composer('*', function ($view) {
            static $demoUsers = null;
            if ($demoUsers === null) {
                try {
                    $demoUsers = User::whereHas('role', function ($query) {
                        $query->where('name', '!=', 'dev');
                    })->get();
                } catch (\Exception $e) {
                    $demoUsers = collect();
                }
            }
            $view->with('demoUsers', $demoUsers);
        });
    }
}
