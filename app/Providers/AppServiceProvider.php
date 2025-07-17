<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
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
    public function boot(): void
    {
        // Define who can view moderation pages
        // For simplicity, we're allowing user ID 1 or any user with is_admin=true
        Gate::define('viewModeration', function ($user) {
            return $user->id === 1 || $user->is_admin;
        });
    }
}
