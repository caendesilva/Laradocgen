<?php

/*
 * Docgen Configuration
 */
return [
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
