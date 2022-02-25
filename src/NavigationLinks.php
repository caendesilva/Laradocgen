<?php

namespace Caendesilva\Docgen;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;

/**
 * The Navigation Links Object
 */
class NavigationLinks
{
    protected Collection $links;

    public function __construct()
    {
        $this->links = $this->generate();
    }

    public function get(): Collection
    {
        return $this->links;
    }

    public function withoutRoutes(array $routes = ['index', '404']): self
    {
        // Remove the specified routes from the collection

        $this->links = $this->links->reject(function ($link) use ($routes) {
            return in_array($link->slug, $routes);
        });

        return $this;
    }

    public function order(): self
    {
        // Order according to the index or throw error if index does not exist
        $this->links = $this->links->sortBy('order')->values();

        return $this;
    }

    private function generate(): Collection
    {
        // build a collection of links
        $links = new Collection;
        foreach (Docgen::getMarkdownFileSlugsArray() as $slug) {
            $links->push(new NavigationLink($slug));
        }
        return $links;
    }
}
