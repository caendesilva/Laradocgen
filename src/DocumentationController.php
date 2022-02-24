<?php

namespace Caendesilva\Docgen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

/**
 * @todo add configs, for example to the route prefix
 */
class DocumentationController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return redirect()->route('docs.show', ['slug' => 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(string $slug = 'index')
    {
        return view('docgen::app', [
			// Page object
			// 'title' => str_replace('-', ' ', Str::title($slug)),
			// 'markdown' => Docgen::getMarkdownFromSlugOrFail($slug),
			// 'slug' => $slug,
			'page' => (new MarkdownPage($slug)),


			// Layout object
			'links' => (new NavigationLinks())->withoutIndex()->order()->get(),
			// 'links' => Docgen::getMarkdownFileSlugsArray(),
			'rootRoute' => '/docs/master/',
		]);
    }
}
