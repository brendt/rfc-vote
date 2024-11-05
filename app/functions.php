<?php

use League\CommonMark\MarkdownConverter;

if (! function_exists('md')) {
    function md(string $contents): string
    {
        /** @var MarkdownConverter $markdown */
        $markdown = app(MarkdownConverter::class);

        return $markdown->convert($contents)->getContent();
    }
}
