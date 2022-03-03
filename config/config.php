<?php

/*
 * Laradocgen Configuration
 */
return [
    /**
     * Site Name Override.
     * 
     * The name of the documentation page shown in the sidebar and page title.
     *
     * If the setting is not set the name will be automatically created title based on
     * the name set in default Laravel config/app.php 'name' setting.
     * 
     * For example, if your app name is 'Laravel' and the setting below is not set,
     * the name displayed in the documentation site will be 'Laravel Docs'.
     */
    'siteName' => null,

    /**
     * Should links between pages in the static site end in .html?
     * 
     * If true links will be rendered as: <a href="index.html">Home</a>
     *      This allows the HTML file links work offline 
     * If false links will be rendered as: <a href="index">Home</a>
     *      This gives a cleaner URI path, but breaks links offline.
     *      May or may not work depending on your server configuration.
     * 
     * Note that when using the realtime preview this will be 
     * set to false, so it is compatible with Laravel routing.
     */
    'useDotHtmlInLinks' => true, 

    /**
     * Document Source Path.
     * 
     * The directory where the source Markdown files are stored (relative to the Laravel root)
     * 
     * The default directory is <laravel-project>/resources/docs/
     * With media stored in <laravel-project>/resources/docs/media/
     */
    'sourcePath' => env('LARADOCGEN_SOURCE_PATH', 'resources/docs'),

    /**
     * HTML Build Path.
     * 
     * The directory where the compiled HTML is output (relative to the Laravel root)
     * 
     * The default directory is <laravel-project>/public/docs/
     */
    'buildPath' => env('LARADOCGEN_BUILD_PATH', 'public/docs'),

    /**
     * The webserver to fetch contents from
     *
     * The static site builder compiles Blade by fetching the HTML from your web-server.
     * By default, it uses `http://localhost:8000/`, but you can change it if you for example
     * are serving the site through docker or WSL or are using a different port.
     */
    'serverHost' => 'http://localhost:8000/',

    /**
     * Search feature. (Experimental)
     * 
     * Should the search feature be enabled?
     * Generates a searchIndex.json file that a simple
     * vanilla JavaScript uses to filter search results.
     * 
     * Note, the search index is generated using the laradocgen:build Artisan command.
     * The realtime viewer does at this point not generate it automatically.
     * 
     * Disable this if you are using a "smarter" service such as Algolia 
     */
    'search' => true,

    /**
     * Copyright text.
     * 
     * Should the footer display a copyright license for the documentation text?
     */
    'copyright' => [
        'enabled' => false,
        'licenseName' => 'CC BY-SA 4.0',
        'licenseUri' => 'https://creativecommons.org/licenses/by-sa/4.0/',
    ],

    /**
     * Should Algolia be used?
     *
     * Laradocgen supports Algolia indirectly by providing the layout scaffolding.
     * To use Algolia, first name sure that the built in search feature is disabled.
     * Then publish the laradocgen views and update the components/algolia-scripts
     * Blade file with your project details.
     *
     * @see https://docsearch.algolia.com/docs/DocSearch-v3
     */
    'useAlgolia' => false,


    /**
     * DANGER ZONE:
     * 
     * The following features are experimental and may be dangerous.
     * Use at your own risk. Report any issues on GitHub!
     */

    /**
     * Absolute Source and Build Paths
     * 
     * WARNING: This feature is experimental and may override files you do not want to override.
     * Only enable this if you know what you are doing!
     * 
     * By default the source and build paths are relative to your Laravel installation.
     * You can uncomment the following to use absolute paths (to use paths outside your Laravel installation)
     * This may not work if you don't have permission to access the files.
     */
    // 'enableAbsolutePathOverride' => false,
    // 'absoluteSourcePath' => '/ubuntu/example/path/output/',
    // 'absoluteBuildPath' => 'C:\Windows\Example\Path\Output\\',
    
];
