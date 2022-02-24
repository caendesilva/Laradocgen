<?php

namespace Caendesilva\Docgen;

use Illuminate\Support\ServiceProvider;

use League\CommonMark\MarkdownConverter;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;
use League\CommonMark\Extension\Footnote\FootnoteExtension;
use Torchlight\Commonmark\V2\TorchlightExtension;
use League\CommonMark\Environment\Environment;

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
            ], 'docgen');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/docgen'),
            ], 'views');*/

            // Publishing the markdown files.
            $this->publishes([
                __DIR__.'/../resources/docs' => resource_path('docs'),
            ], 'docgen');
            
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

        // Register a new Markdown Singleton
        $this->app->singleton('docgen.converter', function ($app) {
            $config = [
                'table_of_contents' => [
            
                ],
            
                'heading_permalink' => [
                    'min_heading_level' => 3,
                    'max_heading_level' => 6,
                    'insert' => 'after',
                    'symbol' => '#',
                    'id_prefix' => '',
                    'fragment_prefix' => '',
                ],
            ];
            
            $environment = new Environment($config);
		
            $environment->addExtension(new GithubFlavoredMarkdownExtension());

            $environment->addExtension(new CommonMarkCoreExtension());
            
            $environment->addExtension(new HeadingPermalinkExtension());
            $environment->addExtension(new TableOfContentsExtension());
            $environment->addExtension(new FootnoteExtension());

    
            if (config('docgen.useTorchlight')) {
                $environment->addExtension(new TorchlightExtension());
            }
    

            return new MarkdownConverter($environment);
        });
    }
}
