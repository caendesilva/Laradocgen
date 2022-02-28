<?php

use DeSilva\Laradocgen\DocumentationController;
use Illuminate\Support\Facades\Route;

// Register routes only in the local environment
if (config('app.env') === 'local') {
    // Redirect helpers
    Route::get('realtime-docs/{slug}.html', function ($slug = 'index') {
        # Redirect in case a realtime request has a .html ending
        return redirect('realtime-docs/' . $slug);
    });
    Route::get('realtime-docs', function () {
        return redirect()->route('docs.realtime', ['slug' => 'index']);
    });

    // Package routes

    // The realtime documentation resource route.
    Route::get('realtime-docs/{slug}', function ($slug = 'index') {
        // Generates the views on-the-fly by setting the realtime parameter in the show method to true.
        return (new DocumentationController)->show($slug, true);
    })->name('docs.realtime');
    
    Route::get('/api/laradocgen/realtime-media-asset/{file}', function ($file) {
        // API to serve images
        return (new DocumentationController)->realtimeAsset($file);
    })->name('docs.realtime.media-asset');


    // The routes used by the Static Page Builder when generating the static HTML.
    Route::get('documentation-generator/{slug}', function ($slug) {
        return (new DocumentationController)->show($slug);
    })->name('docs.show');
}
