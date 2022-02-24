<?php

use Caendesilva\Docgen\DocumentationController;

Route::get('docs', [DocumentationController::class, 'index'])->name('docs.index');
Route::get('docs/master', [DocumentationController::class, 'index'])->name('docs.index');
Route::get('docs/master/{slug}', function ($slug) {
	return (new DocumentationController)->show($slug);
})->name('docs.show');