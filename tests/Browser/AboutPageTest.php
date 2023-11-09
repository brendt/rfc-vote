<?php

uses(\Tests\DuskTestCase::class);
use App\Support\FetchContributors;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\About\Contributors;
use Tests\Browser\Pages\AboutPage;

uses(\Illuminate\Foundation\Testing\DatabaseTruncation::class);

test('it renderers all sections', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit(new AboutPage)
            ->assertSee('Shaping PHP, together')
            ->assertSee("Who's involved?")
            ->assertSee('Our contributors')
            ->assertSee('Interesting links');
    });
});

test('it renders repo link and yt playlist link in interesting links section', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit(new AboutPage)
            ->with('@interesting-links-container', function (Browser $browser) {
                $browser->assertSeeLink('The RFC Vote repository')
                    ->assertSeeLink('The YouTube playlist');
            });
    });
});

test('it renders contributors', function () {
    $this->browse(function (Browser $browser) {
        $contributors = app(FetchContributors::class);

        $browser->visit(new AboutPage)
            ->with(new Contributors, function (Browser $browser) use ($contributors) {
                $contributor = $contributors->getContributors()[0];
                $browser->with("a[href=\"$contributor->url\"]", function (Browser $browser) use ($contributor) {
                    $browser->assertSee($contributor->name)
                        ->assertSee(implode(', ', $contributor->contributions));
                });
            });
    });
});
