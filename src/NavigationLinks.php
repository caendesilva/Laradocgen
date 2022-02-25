<?php

namespace Caendesilva\Docgen;

use Illuminate\Support\Collection;

/**
 * Creates a Collection of NavigationLink objects
 * 
 * @todo It may make more sense to rename this to MarkdownPageCollection
 *
 * The Collection is used to create the sidebar
 * and the Collection of files for the
 * StaticPageBuilder to generate.
 *
 * @uses NavigationLink
 *
 * @method $this withoutRoutes(array $routes = []) removes the specified routes
 * @method $this order() sort the Collection
 *
 * @method \Illuminate\Support\Collection get() returns the Collection
 */
class NavigationLinks
{
    /**
     * The Collection object
     *
     * @var \Illuminate\Support\Collection
     */
    protected Collection $links;

    /**
     * Construct the object by generating the Collection
     */
    public function __construct()
    {
        $this->links = $this->generate();
    }

    /**
     * Create a new Collection
     *
     * @uses Docgen::getMarkdownFileSlugsArray()
     * @uses NavigationLink
     *
     * @return Collection $links
     */
    private function generate(): Collection
    {
        $links = new Collection;

        // Get the array of Markdown files and loop through it
        foreach (Docgen::getMarkdownFileSlugsArray() as $slug) {
            // Create a new NavigationLink object and push it to the Collection
            $links->push(new NavigationLink($slug));
        }

        // Return the Collection
        return $links;
    }

    /**
     * Remove the specified routes from the collection.
     *
     * If the route parameter is not set it defaults to removing the 'index' and '404' routes.
     *
     * @param array $routes to remove
     * @return self
     */
    public function withoutRoutes(array $routes = ['index', '404']): self
    {
        /**
         * Reject the routes using the Collection method reject()
         *
         * @see https://laravel.com/docs/9.x/collections#method-reject
         */
        $this->links = $this->links->reject(function ($link) use ($routes) {
            /**
             * If the slug we are comparing is in the $routes array
             * we return true which instructs the reject method
             * that the entry should be removed.
             */
            return (bool) in_array($link->slug, $routes);
        });

        return $this;
    }

    /**
     * Sort the Collection by the order priority set in the NavigationLink object
     *
     * @return self
     */
    public function order(): self
    {
        /**
         * Sort the Collection using the sortBy() method
         * @see https://laravel.com/docs/9.x/collections#method-sortby
         */
        $this->links = $this->links
            ->sortBy('order') // Sort by the NavigationLink->order property
            ->values(); // Use values() to reset the Collection keys to consecutively numbered indexes:

        return $this;
    }

    /**
     * Get the Collection instance
     *
     * @return Collection
     */
    public function get(): Collection
    {
        return $this->links;
    }
}
