<?php

namespace DeSilva\Laradocgen;

use Illuminate\Support\Str;

/**
 * The Navigation Link Object
 *
 * @todo Refactor to work with the MarkdownPage::class.
 *       In case we rename NavigationLink::class to MarkdownPageCollection::class
 *       we may merge this class entirely with the MarkdownPage::class as they
 *       share similar scopes and functions already.
 *
 * Used in generating the sidebar
 *
 * Is part of the NavigationLinks collection
 * @see NavigationLinks
 */
class NavigationLink
{
    /**
     * The slug of the Link. Must be passed in the constructor.
     *
     * @var string
     */
    public string $slug;

    /**
     * The generated title of the Link.
     *
     * @var string
     */
    public string $title;

    /**
     * The generated sidebar priority. Lower values are shown first.
     *
     * @var int
     */
    public int $order;

    /**
     * Construct the link object
     *
     * @param string $slug of the link. If it is not set, default to the 'index' slug
     */
    public function __construct(string $slug = 'index')
    {
        $this->slug = $slug;
        $this->title = $this->getTitle();
        $this->order = $this->getOrder();
    }

    /**
     * Create a pretty title from the slug.
     *
     * @todo should use a method from the MarkdownPage object
     *
     * @example 'hello-world' becomes 'Hello World'
     *
     * @return string
     */
    private function getTitle(): string
    {
        return str_replace('-', ' ', Str::title($this->slug));
    }

    /**
     * Get the index of the slug.
     *
     * This is here used to determine the priority (order) of sidebar links.
     *
     * @uses ParsesLinkIndex::getIndexOfSlug() to get the index.
     *          If the index is not set in the docs/linkIndex.yml we return priority 999.
     *
     * @return int
     */
    private function getOrder(): int
    {
        return ParsesLinkIndex::getIndexOfSlug($this->slug, 999);
    }
}
