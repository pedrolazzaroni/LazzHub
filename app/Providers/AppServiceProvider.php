<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GeminiService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registrar o GeminiService no container de serviços
        $this->app->singleton(GeminiService::class, function ($app) {
            return new GeminiService();
        });

        // ...existing code...
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
