<?php

namespace Caendesilva\Docgen;

use Illuminate\Support\Str;

/**
 * The Markdown Page Object
 * 
 * @todo This class contains similar code as the NavigationLink::class.
 *          Merging them, or referencing this class in the other one would
 *          allow for better maintainability.
 * 
 * Passed to the view through the DocumentationController,
 * the MarkdownPage object contains information about the Page.
 * It holds data such as the page title and the Markdown contents.
 * 
 * @see resources/app.blade.php  
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
     * The converted HTML
     * 
     * @var string
     */
    public string $markdown;

    /**
     * Construct the page object
     * 
     * @param string $slug of the page. Defaults to 'index'
     */
    public function __construct(string $slug = 'index')
    {
        $this->slug = $slug;
        $this->title = $this->getTitle();
        $this->markdown = $this->getMarkdown();
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
    private function getMarkdown(): string
    {
        return Docgen::getMarkdownFromSlugOrFail($this->slug);
    }
}
