<?php

namespace DeSilva\Laradocgen;

use Illuminate\Support\Str;

/**
 * The Markdown Page Object
 *
 * Passed to the app.blade.php view through the DocumentationController,
 * the MarkdownPage object contains information about the Page.
 * It holds data such as the page title and the Markdown contents.
 *
 * @see DocumentationController::show()
 */
class MarkdownPage
{
    /**
     * The page slug
     *
     * @var string
     */
    public string $slug;

    /**
     * The page title
     *
     * @var string
     */
    public string $title;

    /**
     * The generated sidebar priority.
     * Lower values are shown first.
     *
     * @var int
     */
    public int $order;

    /**
     * The converted Markdown as HTML
     *
     * @var string
     */
    public string $markdown;

    /**
     * Construct the page object
     *
     * @param string $slug              of the page. Defaults to 'index'
     * @param bool   $isRealtimeRequest for on-the-fly generation?
     */
    public function __construct(string $slug = 'index', bool $isRealtimeRequest = false)
    {
        $this->slug = $slug;
        $this->title = $this->getTitle();
        $this->order = $this->getOrder();
        $this->markdown = $this->getConvertedMarkdown();

        /**
         * Temporary as it will be done in the preprocessor (or post-processor)
         * after I restructure and remove the deprecated method.
         */
        if ($isRealtimeRequest) {
            $this->markdown = str_replace(
                '<img src="media/',
                '<img src="/api/laradocgen/realtime-media-asset/',
                $this->markdown
            );
        }
    }

    /**
     * Create the title from the slug
     *
     * @return string
     */
    private function getTitle(): string
    {
        return str_replace('-', ' ', Str::title($this->slug));
    }

    /**
     * Convert the Markdown to HTML
     *
     * @return string
     */
    private function getConvertedMarkdown(): string
    {
        return (new MarkdownConverter(
            Laradocgen::getSourceFileContents($this->slug . '.md')
        ))->parse();
    }

    /**
     * Get the index of the slug.
     *
     * This is used to determine the priority (order) of sidebar links.
     *
     * @uses ParsesLinkIndex::getIndexOfSlug() to get the index.
     *       If the index is not set in the docs/linkIndex.yml we return priority 999.
     *
     * @return int
     */
    private function getOrder(): int
    {
        return ParsesLinkIndex::getIndexOfSlug($this->slug, 999);
    }
}
