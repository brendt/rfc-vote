<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class DuskHelperTest extends TestCase
{
    public function test_it_renders_nothing_if_in_production_env(): void
    {
        app()->detectEnvironment(fn () => 'production');
        $this->assertFalse(dusk('test'));
    }

    public function test_it_renders_dusk_selector_for_given_string(): void
    {
        $this->assertEquals('dusk="test"', dusk('test'));
    }
}
