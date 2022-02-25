<?php

namespace Caendesilva\Docgen;

use App\Http\Controllers\Controller;

/**
 * Resource controller for the Documentation views
 *
 * @todo add config options
 */
class DocumentationController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @todo add feature that re-compiles static html when the realtime viewer is active.
     *          This could work by comparing checksums or file sizes
     *
     * @uses MarkdownPage
     * @uses NavigationLinks
     *
     * @param string $slug of the file to show
     * @param bool $realtime is it a realtime request for on-the-fly generation?
     * @return \Illuminate\View\View
     */
    public function show(string $slug, bool $realtime = false)
    {
        // Validate the slug
        $slug = $this->handle404($slug);

        /**
         * Create a MarkdownPage object from the slug.
         * The object contains the page content.
         */
        $page = new MarkdownPage($slug);

        /**
         * Create the NavigationLinks object which contains the sidebar information
         */
        $links = (new NavigationLinks())
            ->withoutRoutes(['index', '404'])
            ->order()
            ->get();

        // Get the name of the site
        $siteName = DocgenFacade::getSiteName();

        /**
         * Determine the root path. This is used to prefix the relative URLs.
         */
        $rootRoute =  $realtime ? '/realtime-docs/' : '/docs/';


        // Return the view
        return view('docgen::app', [
            'page' => $page,
            'links' => $links,
            'siteName' => $siteName,
            'realtime' => $realtime,
            'rootRoute' => $rootRoute,
        ]);
    }

    /**
     * Check if the specified slug exists as a page. Else swap the slug out for a 404.
     * This way the user's url is preserved and we don't redirect to a 404 page.
     *
     * @param string $slug
     * @return string $slug
     */
    private function handle404(string $slug): string
    {
        return Docgen::validateExistence($slug) ? $slug : '404';
    }
}
