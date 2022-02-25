<?php

namespace DeSilva\LaraDocGen;

/**
 * Compile a Laravel route into static HTML
 *
 * @todo add option to change source and output directories (PRs welcome!)
 *
 * @author Caen De Silva
 */
class StaticPageBuilder
{
    /**
     * The directory where the source files are stored.
     * Usually <laravel-project>/resources/docs/
     *
     * @var string
     */
    private string $sourcePath;

    /**
     * The directory where the compiled static files are stored.
     * Usually <laravel-project>/public/docs/
     * Media files such as images are in <laravel-project>/public/docs/media/
     *
     * @var string
     */
    private string $buildPath;

    /**
     * The Collection of Pages to compile.
     *
     * @uses NavigationLinks
     * @var \Illuminate\Support\Collection
     */
    protected \Illuminate\Support\Collection $pageCollection;

    /**
     * Construct the Builder
     */
    public function __construct()
    {
        // Start the build
        $time_start = microtime(true);
        echo "Starting build \n";

        // Set the source path
        $this->sourcePath = resource_path() . '/docs/';
        // Set the build path
        $this->buildPath = public_path() . '/docs/';

        // Check if the directories exists, otherwise create them
        $this->ensureDirectoryExists();

        // Get the Page Collection
        $this->pageCollection = $this->getPageCollection();

        // Start the Build Loop and store the output count in a variable
        echo "Starting Build Loop. This may take a while. \n";
        $count = $this->startBuildLoop();
        echo "Finished Build Loop \n";

        // Copy the media assets and store the output count in a variable
        echo "Copying media assets \n";
        $mediaCount = $this->copyAssets();
        echo "Finished copying media assets \n";

        // Add directory checksum to checksums.json

        // Stop the build and format the time
        $time = (float) ((microtime(true) - $time_start));
        echo "\nDone. Generated " . $count .
            ' pages and copied ' . $mediaCount
            . ' files in ' . sprintf('%f', $time) . ' seconds';
    }

    /**
     * Check if the build directories exists, otherwise create them.
     *
     * @return void
     */
    private function ensureDirectoryExists(): void
    {
        // Does build directory exist else create it
        is_dir($this->buildPath) || mkdir($this->buildPath);
        // Does media directory exist else create it
        is_dir($this->buildPath . 'media') || mkdir($this->buildPath . 'media');
    }

    /**
     * Get the Collection of pages using the NavigationLinks interface.
     *
     * @uses NavigationLinks
     * @return \Illuminate\Support\Collection $pageCollection
     */
    private function getPageCollection(): \Illuminate\Support\Collection
    {
        return (new NavigationLinks)->get();
    }

    /**
     * Start the Build Loop which iterates through all the pages in the
     * pageCollection and subsequently builds the pages.
     *
     * @return int $count of files built
     */
    private function startBuildLoop(): int
    {
        $count = 0;
        foreach ($this->pageCollection as $page) {
            $this->buildPage($page->slug);
            $count++;
        }
        return $count;
    }

    /**
     * Compile the page and store it to file.
     *
     * @param string $slug
     * @return void
     */
    private function buildPage(string $slug): void
    {
        // Which builder should be used?
        $builder = 'curl';

        // Construct the url
        $url = 'http://localhost:8000/documentation-generator/' . $slug;

        // Determine which Builder to use and retrieve the HTML using the builder.
        switch ($builder) {
            case 'getContents':
                echo " > Building page {$slug}.html with the getContents Builder \n";
                $html = $this->getContentsBuilder($url);
                break;

            case 'curl':
                echo " > Building page {$slug}.html with the Curl Builder \n";
                $html = $this->curlBuilder($url);
                break;

            default:
                throw new \Exception("Unknown Builder $builder", 1);
                break;
        }

        // Construct the filename
        $filename = $this->buildPath . $slug . '.html';

        // Save the HTML to the file
        file_put_contents($filename, $html);

        // Add file checksum to checksums.json
    }

    /**
     * Get HTML using file_get_contents (Not Recommended)
     *
     * Has issue with JavaScript needed to render the sidebar,
     * and is thus not recommended for use. Use Curl instead.
     *
     * @param string $url
     * @return string $html
     */
    private function getContentsBuilder(string $url): string
    {
        $html = file_get_contents($string);

        return $html;
    }

    /**
     * Get the HTML using Curl. (Recommended)
     *
     * @param string $url
     * @return string $html
     */
    private function curlBuilder(string $url): string
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $html = curl_exec($curl);
        curl_close($curl);

        return $html;
    }

    /**
     * Copy all the media files from the sourcePath/media directory to the buildPath/media directory.
     *
     * @return int $count of files copied
     */
    private function copyAssets(): int
    {
        $count = 0;
        foreach (glob($this->sourcePath . "media/*.{png,svg,jpg,jpeg,gif}", GLOB_BRACE) as $filepath) {
            echo " > Copying file " . basename($filepath) . " to the output media directory \n";
            copy($filepath, $this->buildPath . 'media/' . basename($filepath));
            $count++;
        }

        // Copy CSS from public/vendor to media/app.css
        return $count;
    }
}
