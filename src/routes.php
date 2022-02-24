<?php

use Caendesilva\Docgen\DocumentationController;

if (config('app.env') === 'local') {
	Route::get('realtime-docs/{slug}.html', function ($slug = 'index') {
		# Redirect in case a realtime request has a .html ending
		return redirect('realtime-docs/' . $slug);
	});

	Route::get('realtime-docs', function () {
      	return redirect()->route('docs.realtime', ['slug' => 'index']);
	});
	Route::get('realtime-docs/{slug}', function ($slug = 'index') {
		return (new DocumentationController)->show($slug, true);
	})->name('docs.realtime');
	
	Route::get('documentation-generator/{slug}', function ($slug) {
		return (new DocumentationController)->show($slug);
	})->name('docs.show');
}