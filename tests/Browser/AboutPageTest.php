<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\AboutPage;
use Tests\DuskTestCase;

class AboutPageTest extends DuskTestCase
{
    public function test_it_renderers_all_sections(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new AboutPage)
                ->assertSee('Shaping PHP, together')
                ->assertSee("Who's involved?")
                ->assertSee('Our contributors')
                ->assertSee('Interesting links');
        });
    }

    public function test_it_renders_repo_link_and_yt_playlist_link_in_interesting_links_section(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new AboutPage)
                ->with('@interesting-links-container', function (Browser $browser) {
                    $browser->assertSeeLink('The RFC Vote repository')
                        ->assertSeeLink('The YouTube playlist');
                });
        });
    }
}
