<?php
namespace App\Providers;

use App\Services\ModerationService;
use Illuminate\Support\ServiceProvider;

class ModerationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register the ModerationService as a singleton
        // This ensures we use the same instance throughout the application
        $this->app->singleton(ModerationService::class, function ($app) {
            return new ModerationService();
        });
    }
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}