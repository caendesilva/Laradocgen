<?php

namespace DeSilva\Laradocgen;

use Exception;
use Illuminate\View\View;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Resource Controller for the Documentation views.
 *
 * @todo add config options
 */
class DocumentationController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param string $slug of the Markdown page to show
     * @param bool $realtime is it a realtime request for on-the-fly generation?
     * @return View
     * @throws Exception if a required file is missing
     * @uses MarkdownPage
     * @uses MarkdownPageCollection
     *
     * @todo add feature that re-compiles static html when the realtime viewer is active.
     *          This could work by comparing checksums or file sizes.
     *          The advantage of this is that the preview should match
     *          the result files to prevent unexpected behavior.
     */
    public function show(string $slug, bool $realtime = false): View
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
         * Create the MarkdownPageCollection object which contains the sidebar information
         */
        $links = (new MarkdownPageCollection())
            ->withoutRoutes(['index', '404'])
            ->order()
            ->get();

        // Get the name of the site
        $siteName = Laradocgen::getSiteName();

        /**
         * Determine the root path. This is used to prefix the relative URLs.
         * @deprecated as it is not used
         */
        $rootRoute =  $realtime ? '/realtime-docs/' : '/docs/';

        // Return the view
        return view('laradocgen::app', data: [
            'page' => $page,
            'links' => $links,
            'siteName' => $siteName,
            'realtime' => $realtime,
            'rootRoute' => $rootRoute,
            'realtimeStyles' => $realtimeStyles ?? false,
            'realtimeScripts' => $realtimeScripts ?? false,
            'pageTitle' => ($page->slug === "index") ? $siteName : "$page->title | $siteName",
        ]);
    }

    /**
     * Return a media file for the realtime viewer.
     *
     * @param string $file filename relative to the source media path
     * @return string of the file contents
     *
     * @throws NotFoundHttpException if the file could not be found
     */
    public function realtimeAsset(string $file): string
    {
        try {
            $filepath = resource_path('docs/media/' . $file);
            if (!str_contains(mime_content_type($filepath), 'image')) {
                abort(401);
            }

            header('Content-Type: image');
            return readfile($filepath);
        } catch (Exception) {
            abort(404);
        }
    }

    /**
     * Check if the specified slug exists as a page.
     *
     * If page is not found, we swap the slug out for a 404.
     * This way the user's url is preserved, and we don't redirect
     * to a 404 page which can be jarring for the user.
     *
     * @param  string $slug to validate
     * @return string $slug the same slug if it exists, else 404
     */
    private function handle404(string $slug): string
    {
        return Laradocgen::validateExistenceOfSlug($slug) ? $slug : '404';
    }
}
