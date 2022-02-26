<?php

namespace DeSilva\Laradocgen;

use DeSilva\Laradocgen\BuildCommand;

use Illuminate\Support\ServiceProvider;

use League\CommonMark\MarkdownConverter;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;
use League\CommonMark\Extension\Footnote\FootnoteExtension;
use Torchlight\Commonmark\V2\TorchlightExtension;
use League\CommonMark\Environment\Environment;

class LaradocgenServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laradocgen');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laradocgen');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('laradocgen.php'),
            ], 'laradocgen');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laradocgen'),
            ], 'views');*/

            // Publishing the markdown files.
            $this->publishes([
                __DIR__ . '/../resources/docs' => resource_path('docs'),
            ], 'laradocgen');

            // Publishing assets.
            // $this->publishes([
            //     __DIR__ . '/../resources/assets' => public_path('vendor/laradocgen'),
            // ], 'laradocgen');

            // Publishing the stylesheet
            $this->publishes([
                __DIR__ . '/../resources/assets' => resource_path('docs/media'),
            ], 'laradocgen');

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laradocgen'),
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
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'laradocgen');

        // Register the main class to use with the facade
        $this->app->singleton('laradocgen', function () {
            return new Laradocgen;
        });

        // Register a new Markdown Singleton
        $this->app->singleton('laradocgen.converter', function ($app) {
            // Create the Commonmark Environment Config
            $config = [
                'table_of_contents' => [],

                'heading_permalink' => [
                    'min_heading_level' => 2,
                    'max_heading_level' => 6,
                    'insert' => 'after',
                    'symbol' => '#',
                    'id_prefix' => '',
                    'fragment_prefix' => '',
                ],
            ];

            // Create the Environment
            $environment = new Environment($config);

            // Add the Extensions
            $environment->addExtension(new GithubFlavoredMarkdownExtension());

            $environment->addExtension(new CommonMarkCoreExtension());

            $environment->addExtension(new HeadingPermalinkExtension());
            $environment->addExtension(new TableOfContentsExtension());
            $environment->addExtension(new FootnoteExtension());


            if (config('laradocgen.useTorchlight')) {
                $environment->addExtension(new TorchlightExtension());
            }

            // Return the Converter to the Singleton Registrar
            return new MarkdownConverter($environment);
        });
    }
}
