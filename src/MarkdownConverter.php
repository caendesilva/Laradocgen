<?php

namespace DeSilva\Laradocgen;

/**
 * Wrapper for the Commonmark Markdown Converter
 * Singleton registered in the Service Provider
 *
 * Converts CommonMark-compatible Markdown to HTML.
 *
 * @uses MarkdownPreprocessor
 */
class MarkdownConverter
{
    /**
     * The Markdown string to be converted into HTML
     *
     * @var string $markdown
     */
    protected string $markdown;

    /**
     * Construct the class
     *
     * @param string $markdown
     */
    public function __construct(string $markdown)
    {
        // Run the Markdown PreProcessor
        $this->markdown = (new MarkdownPreprocessor($markdown))->get();
    }

    /**
     * @return string $html
     */
    public function parse(): string
    {
        return app('laradocgen.converter')->convert($this->markdown);
    }
}
