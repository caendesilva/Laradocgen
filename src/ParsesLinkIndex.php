<?php

namespace Caendesilva\Docgen;

/**
 * Parse the link index file
 *
 * Use findIndexOfSlug for OOP
 * Or use shorthand getIndexOfSlug for static facade
 */
class ParsesLinkIndex
{
    public static function getIndexOfSlug(string $slug, int|bool $default = false): int|false
    {
        # Static facade interface
        return (new self)->findIndexOfSlug($slug, $default);
    }

    private string $filePath;

    private array $index;

    public function __construct()
    {
        $this->filePath = resource_path() . '/docs/linkIndex.yml';

        if (!file_exists($this->filePath)) {
            throw new \Exception("Could not find the link index! Did you create one?", 1);
        }
        
        $this->index = $this->parseYamlToArray();
    }

    public function parseYamlToArray(): array
    {
        // Stupidly simple parser, rather inefficient probably but since most files won't have long indexes I think it's okay

        $yaml = (file_get_contents($this->filePath));

        $lines = explode(PHP_EOL, $yaml);

        $array = [];

        foreach ($lines as $line) {
            if (substr($line, 0, 4) == "  - ") {
                $array[] = substr($line, 4);
            }
        }

        return $array;
    }

    public function findIndexOfSlug(string $slug, int|bool $default = false): int|false
    {
        $search = array_keys($this->index, $slug);
        return $search // If search results in a value that is not false
            ? array_shift($search) // Return the value
            : $default; // Else return the default value
    }
}
