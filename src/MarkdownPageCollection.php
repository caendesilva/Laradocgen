<?php

namespace DeSilva\Laradocgen;

use Illuminate\Support\Collection;

/**
 * Creates a Collection of MarkdownPage objects
 *
 * The Collection is used to create the sidebar
 * and the Collection of files for the
 * StaticPageBuilder to generate.
 *
 * @uses MarkdownPage
 */
class MarkdownPageCollection
{
    /**
     * The Collection object.
     *
     * @var Collection
     */
    protected Collection $pages;

    /**
     * Construct the object by generating the Collection.
     */
    public function __construct()
    {
        $this->pages = $this->generate();
    }

    /**
     * Create a new Collection.
     *
     * @uses Laradocgen::getMarkdownFileSlugsArray()
     * @uses MarkdownPage::class
     *
     * @return Collection $pages
     */
    private function generate(): Collection
    {
        $pages = new Collection;

        // Get the array of Markdown files and loop through it
        foreach (Laradocgen::getMarkdownFileSlugsArray() as $slug) {
            // Create a new MarkdownPage object and push it to the Collection
            $pages->push(new MarkdownPage($slug));
        }

        // Return the Collection
        return $pages;
    }

    /**
     * Remove the specified routes from the collection.
     *
     * If the route parameter is not set it defaults to removing the 'index' and '404' routes.
     *
     * @param  array $routes to remove
     * @return self
     */
    public function withoutRoutes(array $routes = ['index', '404']): self
    {
        /**
         * Reject the routes using the Collection method reject()
         *
         * @see https://laravel.com/docs/9.x/collections#method-reject
         */
        $this->pages = $this->pages->reject(function ($link) use ($routes) {
            /**
             * If the slug we are comparing is in the $routes array
             * we return true which instructs the reject method
             * that the entry should be removed.
             */
            return in_array($link->slug, $routes);
        });

        return $this;
    }

    /**
     * Sort the Collection.
     *
     * Uses the order priority set in the MarkdownPage object
     *
     * @return self
     */
    public function order(): self
    {
        /**
         * Sort the Collection using the sortBy() method
         *
         * @see https://laravel.com/docs/9.x/collections#method-sortby
         */
        $this->pages = $this->pages
            ->sortBy('order') // Sort by the MarkdownPage->order property
            ->values(); // Use values() to reset the Collection keys to consecutively numbered indexes:

        return $this;
    }

    /**
     * Get the created Collection instance.
     *
     * @return Collection
     */
    public function get(): Collection
    {
        return $this->pages;
    }
}
