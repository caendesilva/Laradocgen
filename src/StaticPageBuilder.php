<?php

namespace DeSilva\Laradocgen;

use Exception;
use Illuminate\Support\Collection;

/**
 * Compile a Laravel route into static HTML
 *
 * @author Caen De Silva
 *
 * @todo add option to change source and output directories (PRs welcome!)
 */
class StaticPageBuilder
{
    /**
     * The Collection of Pages to compile.
     *
     * @uses MarkdownPageCollection
     * @var  Collection
     */
    protected Collection $pageCollection;

    /**
     * Construct the Builder.
     *
     * @throws Exception if an invalid builder is specified
     */
    public function __construct()
    {
        // Start the build
        $time_start = microtime(true);
        echo "Starting build \n";

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
        echo sprintf(
            "\nDone. Generated %d pages and copied %d files in %s seconds",
            $count,
            $mediaCount,
            sprintf('%f', $time)
        );
    }

    /**
     * Check if the build directories exists, otherwise create them.
     *
     * @return void
     */
    private function ensureDirectoryExists(): void
    {
        // Does build directory exist else create it
        is_dir(Laradocgen::getBuildPath()) || mkdir(Laradocgen::getBuildPath());
        // Does media directory exist else create it
        is_dir(Laradocgen::getBuildPath() . 'media') || mkdir(Laradocgen::getBuildPath() . 'media');
    }

    /**
     * Get the Collection of pages using the MarkdownPageCollection interface.
     *
     * @uses   MarkdownPageCollection
     * @return Collection $pageCollection
     */
    private function getPageCollection(): Collection
    {
        return (new MarkdownPageCollection)->get();
    }

    /**
     * Start the Build Loop.
     * The loop which iterates through all the pages in
     * the pageCollection and subsequently builds the pages.
     *
     * @uses self::buildPage
     * @return int $count of files built
     * @throws Exception if an invalid builder is specified
     */
    private function startBuildLoop(): int
    {
        $count = 0;
        foreach ($this->pageCollection as $page) {
            $this->buildPage($page->slug, config('laradocgen.builder', 'curl'));
            $count++;
        }
        return $count;
    }

    /**
     * Compile the page and store it to file.
     *
     * @see self::startBuildLoop
     * @param string $slug of the page to compile
     * @param string $builder which builder should be used?
     * @return void
     * @throws Exception if an invalid builder is specified
     */
    private function buildPage(string $slug, string $builder = 'curl'): void
    {
        // Construct the source url
        $url = 'http://localhost:8000/documentation-generator/' . $slug;

        // Determine which Builder to use and retrieve the HTML using the builder.
        switch ($builder) {
            case 'getContents':
                echo " > Building page $slug.html with the getContents Builder \n";
                $html = $this->getContentsBuilder($url);
                break;

            case 'curl':
                echo " > Building page $slug.html with the Curl Builder \n";
                $html = $this->curlBuilder($url);
                break;

            default:
                throw new Exception("Unknown Builder $builder", 1);
        }

        // Validate the HTML (Check if it is empty, and send warning that webserver may be down)

        // Construct the outputFilepath
        $outputFilepath = Laradocgen::getBuildPath() . $slug . '.html';

        // Save the HTML to the file
        file_put_contents($outputFilepath, $html);

        // @todo Add file checksum to checksums.json?
    }

    /**
     * Get HTML using file_get_contents (Not Recommended)
     *
     * Has issue with JavaScript needed to render the sidebar,
     * and is thus not recommended for use. Use Curl instead.
     *
     * @param  string $url
     * @return string $html
     */
    private function getContentsBuilder(string $url): string
    {
        return file_get_contents($url);
    }

    /**
     * Get the HTML using Curl. (Recommended)
     *
     * @param  string $url
     * @return string $html
     */
    private function curlBuilder(string $url): string
    {
        // Run the Curl builder
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $html = curl_exec($curl);
        curl_close($curl);

        // Validate response
        $code = (curl_getinfo($curl)['http_code']);
        if ($code !== 200) {
            if ($code === 0) {
                echo "\033[33mWarning\033[0m: Received a status code of 0 (No Content). Is the webserver down? \n";
            } else {
                echo "\033[33mWarning\033[0m: Received a non-200 ($code) status code from server. \n";
            }
        }

        // Run the HTML
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
        $files = Laradocgen::getSourceFilepath("*.{png,svg,jpg,jpeg,gif,ico}", 'media');
        foreach (glob($files, GLOB_BRACE) as $filepath) {
            echo " > Copying media file " . basename($filepath) . " to the output media directory \n";
            copy($filepath, Laradocgen::getBuildFilepath(basename($filepath), 'media'));
            $count++;
        }

        echo " > Copying app.css stylesheet file to the output media directory \n";
        copy(
            Laradocgen::getSourceFilepath('app.css', 'media'),
            Laradocgen::getBuildFilepath('app.css', 'media')
        );
        $count++;
        if (file_exists(Laradocgen::getSourceFilepath('custom.css', 'media'))) {
            echo " > Found custom.css stylesheet. Merging it with app.css \n";
            $this->mergeStylesheets();
        }

        echo " > Copying app.js file to the output media directory \n";
        copy(
            Laradocgen::getSourceFilepath('app.js', 'media'),
            Laradocgen::getBuildFilepath('app.js', 'media')
        );
        $count++;

        return $count;
    }

    /**
     * Merge the app.css and custom.css
     *
     * @return void
     */
    private function mergeStylesheets(): void
    {
        echo "Merging stylesheets \n";

        $customStyles = Laradocgen::getSourceFileContents('media/custom.css');
        file_put_contents(
            Laradocgen::getBuildPath() .
                "media/app.css",
            PHP_EOL . PHP_EOL .
                "/* Custom styles */" . PHP_EOL . PHP_EOL,
            FILE_APPEND
        );
        file_put_contents(
            Laradocgen::getBuildFilepath('app.css', 'media'),
            $customStyles,
            FILE_APPEND
        );

        echo "Finished merging stylesheets. \n";
    }
}
