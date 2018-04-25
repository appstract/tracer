<?php

namespace Appstract\Tracer;

use Illuminate\Support\ServiceProvider;

class TracerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(\Illuminate\Contracts\Http\Kernel $kernel, Tracer $tracer)
    {
        $this->publishes([
            __DIR__.'/../config/tracer.php' => config_path('tracer.php'),
            __DIR__.'/../assets/css/laravel-tracer.css' => public_path('css/laravel-tracer.css'),
            __DIR__.'/../assets/js/laravel-tracer.js' => public_path('js/laravel-tracer.js'),
        ]);

        $tracer->trace();

        // Add AssetsMiddlware
        if (config('tracer.trace')) {
            $kernel->prependMiddleware('Appstract\Tracer\Middleware\AssetsMiddleware');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/tracer.php', 'tracer');
        $this->app->make('Appstract\Tracer\Tracer');
    }
}
