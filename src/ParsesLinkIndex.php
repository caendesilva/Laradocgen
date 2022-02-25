<?php

namespace Caendesilva\Docgen;

/**
 * Parse the linkIndex.yml file which is used to determine the order the
 * NavigationLinks::class collection for pages in the sidebar.
 */
class ParsesLinkIndex
{
    /**
     * Path where the index is stored.
     * 
     * Usually <laravel-project>/resources/docs/linkIndex.yml
     * 
     * @var string
     */
    private string $filePath;


    /**
     * The created Index array where the key is the
     * numerical index and the value is the slug.
     * 
     * @var array
     */
    private array $index;


    /**
     * Static shorthand to get the index from a slag.
     * 
     * @param string $slug to search
     * @param int|bool $default return value if the slug does not exist in the index
     * 
     * @return int
     */
    public static function getIndexOfSlug(string $slug, int|bool $default = false): int|false
    {
        return (new self)->findIndexOfSlug($slug, $default);
    }


    /**
     * Construct the class
     */
    public function __construct()
    {
        // Set the filePath
        $this->filePath = resource_path() . '/docs/linkIndex.yml';

        // Check if the file exists
        if (!file_exists($this->filePath)) {
            throw new \Exception("Could not find the link index! Did you create one?", 1);
        }

        // Parse the Yaml and set it to the Index array
        $this->index = $this->parseYamlToArray();
    }

    /**
     * Stupidly simple and fast YAML list parser
     *
     * @author Caen De Silva
     *
     * Parses the yaml index file into an array where the key
     * is the index and the value is the slug
     *
     * Benchmarks on AMD Ryzen 7 1800X 8 Cores (Built in PHP server)
     * 10 000 iterations off reading a yaml file with 1000 random entries
     * Total time 3.1478400230 seconds
     * Function average 0.3147840023 milliseconds (0.000314784002ms per line)
     * Max memory usage: 2 mb
     *
     * @return array
     */
    public function parseYamlToArray(): array
    {
        // Get the file contents
        $yaml = (file_get_contents($this->filePath));

        // Create an array of the lines in the yaml file
        $lines = explode(PHP_EOL, $yaml);

        // Initialize the array
        $array = [];

        // Loop through the lines
        foreach ($lines as $line) {
            // Check if the line matches the list format (space space dash space)
            if (substr($line, 0, 4) == "  - ") {
                // Remove the list key from the line to just get the slug
                // and add it to the array. The index will be automatically
                // assigned by using $array[]
                $array[] = substr($line, 4);
            }
        }

        // Return the array
        return $array;
    }

    /**
     * Get the index of a slug.
     *
     * Optionally specify the return value if a slug does not exist in the linkIndex.yml
     *
     * @param string $slug to search
     * @param int|bool $default return value
     * @return int|false returns found value, or the fallback
     */
    public function findIndexOfSlug(string $slug, int|bool $default = false): int|false
    {
        $search = array_keys($this->index, $slug);
        return $search // If search results in a value that is not false
            ? array_shift($search) // Return the value
            : $default; // Else return the default value
    }
}
