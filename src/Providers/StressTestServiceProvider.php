<?php

namespace StressTest\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class StressTestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
         $this->publishes([
             __DIR__.'/../../config/config.php' => config_path('StressTest.php'),
         ], 'config');

        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
         $this->mergeConfigFrom(
             __DIR__.'/../../config/config.php', 'StressTest'
         );
    }
}
