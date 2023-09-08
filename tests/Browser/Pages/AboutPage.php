<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class AboutPage extends Page
{
    public function url(): string
    {
        return '/about';
    }

    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->url());
    }

    public function elements(): array
    {
        return [
            '@element' => '#selector',
        ];
    }
}
