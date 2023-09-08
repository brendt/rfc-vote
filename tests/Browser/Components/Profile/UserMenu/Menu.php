<?php

namespace Tests\Browser\Components\Profile\UserMenu;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component;

class Menu extends Component
{
    public function selector(): string
    {
        return '@user-menu-menu';
    }

    public function assert(Browser $browser): void
    {
        $browser->assertVisible($this->selector());
    }
}
