<?php

namespace Tests;

use Spatie\Browsershot\Browsershot;

final class FakeBrowsershot extends Browsershot
{
    public function base64Screenshot(): string
    {
        return '';
    }
}
