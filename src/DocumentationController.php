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
    public function realtime()
    {
        // return redirect()->route('docs.show', ['slug' => 'index']);
    }
    
    /**
    * Display the specified resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function show(string $slug, bool $realtime = false)
    {
        $slug = $this->handle404($slug);
        
        // If the request is not from the builder
        // compare the checksums or file sizes and if realtime is enabled recompile
        
        // realtime: Is the request from the static page generator or a realtime user
        return view('docgen::app', [
            // Page object
            // 'title' => str_replace('-', ' ', Str::title($slug)),
            // 'markdown' => Docgen::getMarkdownFromSlugOrFail($slug),
            // 'slug' => $slug,
            'page' => (new MarkdownPage($slug)),
            
            'realtime' => $realtime,
            
            // Layout object
            'links' => (new NavigationLinks())->withoutRoutes(['index', '404'])->order()->get(),
            // 'links' => Docgen::getMarkdownFileSlugsArray(),
            'rootRoute' => $realtime ? '/realtime-docs/' : '/docs/',
        ]);
    }
    
    private function handle404(string $slug): string
    {
        // Check if file exists, if it does we return the slug back. Otherwise we swap it out for a 404.
        // This way the user's url is preserved and we don't redirect to a 404 page.
        return Docgen::validateExistence($slug) ? $slug : '404';
    }
}
