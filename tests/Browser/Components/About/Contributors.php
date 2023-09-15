<?php

namespace Tests\Browser\Components\About;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component;

class Contributors extends Component
{
    public function selector(): string
    {
        return '@about-contributors';
    }

    public function assert(Browser $browser): void
    {
        $browser->assertVisible($this->selector());
    }
}
