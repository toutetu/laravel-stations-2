<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        try {
            \DB::connection()->getPDO();
            \Log::info('Database connected: ' . \DB::connection()->getDatabaseName());
        } catch (\Exception $e) {
            \Log::error('Database connection failed: ' . $e->getMessage());
        }
        
        // Paginator::defaultView('layouts.pagination.paginator');
        Paginator::useBootstrap();
    }
}
