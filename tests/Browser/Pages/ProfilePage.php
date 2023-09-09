<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class ProfilePage extends Page
{
    public function url(): string
    {
        return '/profile';
    }

    public function assert(Browser $browser):void
    {
        $browser->assertPathIs($this->url());
    }
}
