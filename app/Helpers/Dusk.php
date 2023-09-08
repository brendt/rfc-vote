<?php

use Illuminate\Support\HtmlString;

if (! function_exists('dusk')) {
    function dusk(string $selector): ?HtmlString
    {
        if (app()->isProduction()) {
            return null;
        }

        return new HtmlString("dusk=\"$selector\"");
    }
}
