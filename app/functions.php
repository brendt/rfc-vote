<?php

use League\CommonMark\MarkdownConverter;

function md(string $contents): string
{
    /** @var MarkdownConverter $markdown */
    $markdown = app(MarkdownConverter::class);

    return $markdown->convert($contents)->getContent();
}
