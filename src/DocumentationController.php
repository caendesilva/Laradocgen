<?php

namespace DeSilva\Laradocgen;

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
    public function show(string $slug, bool $realtime = false): \Illuminate\View\View
    {
        // Validate the resource source files
        Laradocgen::validateSourceFiles();

        // Validate the slug
        $slug = $this->handle404($slug);

        // Run the realtime compiler
        if ($realtime) {
            $compiler = new RealtimeCompiler;
            $realtimeStyles = $compiler->getStyles();
            $realtimeScripts = $compiler->getScripts();
        }

        /**
         * Create a MarkdownPage object from the slug.
         * The object contains the page content.
         */
        $page = new MarkdownPage($slug, $realtime);

        /**
         * Create the NavigationLinks object which contains the sidebar information
         */
        $links = (new NavigationLinks())
            ->withoutRoutes(['index', '404'])
            ->order()
            ->get();

        // Get the name of the site
        $siteName = LaradocgenFacade::getSiteName();

        /**
         * Determine the root path. This is used to prefix the relative URLs.
         */
        $rootRoute =  $realtime ? '/realtime-docs/' : '/docs/';

        // Return the view
        return view('laradocgen::app', [
            'page' => $page,
            'links' => $links,
            'siteName' => $siteName,
            'realtime' => $realtime,
            'rootRoute' => $rootRoute,
            'realtimeStyles' => $realtimeStyles ?? false,
            'realtimeScripts' => $realtimeScripts ?? false,
        ]);
    }

    /**
     * Return a file from the resources/docs/media for the realtime viewer
     *
     * @param string $file
     */
    public function realtimeAsset(string $file)
    {
        try {
            $filepath = resource_path('docs/media/' . $file);
            if (!str_contains(mime_content_type($filepath), 'image')) {
                abort(401);
            }

            header('Content-Type: image');
            return readfile($filepath);
        } catch (\Throwable $th) {
            return abort(404);
        }
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
        return Laradocgen::validateExistenceOfSlug($slug) ? $slug : '404';
    }
}
