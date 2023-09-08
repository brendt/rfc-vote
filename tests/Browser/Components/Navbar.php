<?php

namespace Tests\Browser\Components;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component;

class Navbar extends Component
{
    public function selector(): string
    {
        return '@navbar';
    }

    public function assert(Browser $browser):void
    {
        $browser->assertVisible($this->selector());
    }
}
