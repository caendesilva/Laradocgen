<?php

namespace Caendesilva\Docgen;

use Illuminate\Support\Str;

/**
 * The Navigation Link Object
 */
class NavigationLink
{
	public int $order;
	public string $slug;
	public string $title;

	public function __construct(string $slug = 'index') {
		$this->slug = $slug;
		$this->title = $this->getTitle();
		$this->order = $this->getOrder();
	}

	private function getTitle(): string
	{
		return str_replace('-', ' ', Str::title($this->slug));
	}

	private function getOrder(): int
	{
		return ParsesLinkIndex::getIndexOfSlug($this->slug, 999);
	}
}
