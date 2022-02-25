<?php

namespace DeSilva\LaraDocGen;

/**
 * Wrapper for the Commonmark Markdown Converter
 * Singleton registered in the Service Provider
 *
 * Converts CommonMark-compatible Markdown to HTML.
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
        $this->markdown = $markdown;
    }

    /**
     * @return string $html
     */
    public function parse(): string
    {
        return app('laradocgen.converter')->convert($this->markdown);
    }
}
