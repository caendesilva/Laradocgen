<?php

namespace Caendesilva\Docgen;

class StaticPageBuilder
{
    private string $sourcePath;
    private string $buildPath;

    protected object $pageCollection;

    public function __construct()
    {
        $time_start = microtime(true);
        echo "Starting build \n";
        
        $this->sourcePath = resource_path() . '/docs/';
        $this->buildPath = public_path() . '/docs/';

        $this->ensureDirectoryExists();

        $this->pageCollection = $this->getPageCollection();

        echo "Starting build loop. This may take a while. \n";

        $count = $this->startBuildLoop();

        $this->copyAssets();

        // Add directory checksum to checksums.json

        $time = (float) ((microtime(true) - $time_start));
        echo 'Generated in ' . $count . ' files in ' . sprintf('%f', $time) . ' seconds';
    }

    private function ensureDirectoryExists()
    {
        is_dir($this->buildPath) || mkdir($this->buildPath);
        is_dir($this->buildPath . 'media') || mkdir($this->buildPath . 'media');
    }

    private function getPageCollection()
    {
        return (new NavigationLinks)->get();
    }

    private function startBuildLoop()
    {
        $count = 0;
        foreach ($this->pageCollection as $page) {
            $this->buildPage($page->slug);
            $count++;
        }
        return $count;
    }

    private function buildPage(string $slug)
    {
        // $html = file_get_contents('http://localhost:8000/documentation-generator/' . $slug);

        $url = 'http://localhost:8000/documentation-generator/' . $slug;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //for debug only!
        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);

        $html = $resp;

        file_put_contents($this->buildPath . $slug . '.html', $html);

        // Add file checksum to checksums.json
    }

    private function copyAssets()
    {
        foreach (glob($this->sourcePath . "media/*.{png,svg,jpg,jpeg,gif}", GLOB_BRACE) as $filepath) {
            copy($filepath, $this->buildPath . 'media/' . basename($filepath));
        }
    }
}
