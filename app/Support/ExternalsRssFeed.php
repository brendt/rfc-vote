<?php

namespace App\Support;

use Feed;
use SimpleXMLElement;

/**
 * @codeCoverageIgnore this is a wrapper for `Feed::loadRss`, cannot be tested
 */
class ExternalsRssFeed
{
    public function load(): SimpleXMLElement
    {
        /** @var SimpleXMLElement $rss */
        $rss = Feed::loadRss('https://externals.io/rss');

        return $rss;
    }
}
