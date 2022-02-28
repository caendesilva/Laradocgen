<?php

namespace DeSilva\Laradocgen;

/**
 * Markdown preprocessor.
 *
 * Runs in the MarkdownConverter::class before generating the markdown.
 *
 * @see MarkdownConverter
 *
 * @example usage $processedMarkdown = (new MarkdownPreprocessor($markdown))->get()
 *
 * @uses PreProcessors
 */
class MarkdownPreprocessor extends PreProcessors
{
    /**
     * The Markdown to preprocess
     *
     * @var string $markdown
     */
    protected string $markdown;

    /**
     * Construct the class and run the compiler when the class is created.
     *
     * @param string $markdown to preprocess
     */
    public function __construct(string $markdown)
    {
        $this->markdown = $markdown;

        $this->__invoke();
    }

    /**
     * Run the processor
     */
    public function __invoke()
    {
        $this->expandFilepathShortcode();
    }

    /**
     * Get the processed Markdown
     *
     * @return string
     */
    public function get(): string
    {
        return $this->markdown;
    }
}
