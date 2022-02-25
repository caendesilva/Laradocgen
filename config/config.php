<?php

/*
 * Docgen Configuration
 */
return [
    /**
     * The name of the documentation page shown in the sidebar and page title.
     *
     * Default setting is 'dynamic' with automatically creates a title based on
     * the name set in default Laravel config/app.php 'name' setting.
     *
     * If your app name is 'Laravel' and the setting below is set to 'dynamic'
     * the name displayed in the documentation site will be 'Laravel Docs'.
     */
    'siteName' => 'dynamic',

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
