<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class EmailVerificationPage extends Page
{
    public function url(): string
    {
        return '/email/verify';
    }

    public function assert(Browser $browser):void
    {
        $browser->assertPathIs($this->url());
    }
}
