<?php

namespace Caendesilva\Docgen;

use Illuminate\Support\ServiceProvider;

class DocgenServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'docgen');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'docgen');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('docgen.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/docgen'),
            ], 'views');*/

            // Publishing the markdown files.
            $this->publishes([
                __DIR__.'/../resources/docs' => resource_path('docs'),
            ], 'docs');
            
            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/docgen'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/docgen'),
            ], 'lang');*/

            // Registering package commands.
            $this->commands([
                BuildCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'docgen');

        // Register the main class to use with the facade
        $this->app->singleton('docgen', function () {
            return new Docgen;
        });
    }
}
