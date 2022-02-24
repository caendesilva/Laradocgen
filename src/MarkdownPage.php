<?php

namespace Caendesilva\Docgen;

use Illuminate\Support\Str;

/**
 * The Markdown Page Object
 */
class MarkdownPage
{
	public string $slug;
	public string $title;
	public string $markdown;

	public function __construct(string $slug = 'index') {
		$this->slug = $slug;
		$this->title = $this->getTitle();
		$this->markdown = $this->getMarkdown();
	}

	private function getTitle(): string
	{
		return str_replace('-', ' ', Str::title($this->slug));
	}

	private function getMarkdown(): string
	{
		return Docgen::getMarkdownFromSlugOrFail($this->slug);
	}
}
