<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;

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
        // Set public path to root directory (no public/ folder in this deployment)
        app()->usePublicPath(base_path());

        Blade::component('admin-layout', \App\View\Components\AdminLayout::class);

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        Vite::useBuildDirectory('build');
    }
}
