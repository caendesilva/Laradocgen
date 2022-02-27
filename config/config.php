<?php

/*
 * Laradocgen Configuration
 */
return [
    /**
     * Site name override
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
     * Should Torchlight be used?
     *
     * Is enabled automatically if you have a Torchlight token set in your .env file
     * Default: false
     *
     * @see https://torchlight.dev/docs
     *
     * Remember to add your API token in your .env file
     */
    'useTorchlight' => (env('TORCHLIGHT_TOKEN') !== null) ? true : false,
];
