<?php

namespace Caendesilva\Docgen;

class MarkdownConverter
{
    protected string $markdown;

    public function __construct(string $markdown)
    {
        $this->markdown = $markdown;
    }

    public function parse()
    {
        return app('docgen.converter')->convert($this->markdown);
    }
}
