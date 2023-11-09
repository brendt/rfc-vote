<?php

uses(\Tests\DuskTestCase::class);
use App\Models\Argument;
use App\Models\ArgumentVote;
use App\Models\Rfc;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;

uses(\Illuminate\Foundation\Testing\DatabaseTruncation::class);

beforeEach(function () {
    Queue::fake();
    // generating the meta image for rfcs is expensive
});

test('it renders all main sections', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit(new HomePage)
            ->assertPresent('@navbar')
            ->assertPresent('@footer');
    });
});

test('it renders email notification disclaimer to unauthenticated users', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit(new HomePage)
            ->assertPresent('@disclaimer')
            ->click('@disclaimer a')
            ->assertUrlIs(route('login'));
    });
});

test('it renders email notification disclaimer for auth users that didnt verify email', function () {
    $user = User::factory()->unverified()->create();
    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit(new HomePage)
            ->assertPresent('@disclaimer')
            ->click('@disclaimer a')
            ->assertUrlIs(route('verification.notice'));
    });
});

test('it renders email notification disclaimer for auth users that do not have email notifications enabled', function () {
    $user = User::factory()->create();
    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit(new HomePage)
            ->assertPresent('@disclaimer')
            ->click('@disclaimer a')
            ->assertPathIs('/')
            ->assertNotPresent('@disclaimer');
    });
});

test('it does not render email notifications if user already opted for email notifications', function () {
    $user = User::factory()->withEmailOptin()->create();
    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit(new HomePage)
            ->assertNotPresent('@disclaimer');
    });
});

test('it renders open rfcs section even if there are no open rfcs', function () {
    Rfc::factory()->count(3)->create(
        [
            'published_at' => Carbon::now()->subDays(2),
            'ends_at' => Carbon::now()->subDay(),
        ]
    );
    $this->browse(function (Browser $browser) {
        $browser->visit(new HomePage)
            ->assertPresent('@title')
            ->assertNotPresent('@card-links');
    });
});

test('it renders only open rfcs', function () {
    Rfc::factory()->create(
        [
            'title' => 'This is a test rfc that should not be rendered',
            'published_at' => Carbon::now()->subDays(2),
            'ends_at' => Carbon::now()->subDay(),
        ]
    );

    Rfc::factory()->create(
        [
            'title' => 'This is a test rfc that should be rendered',
            'published_at' => Carbon::now()->subDays(2),
            'ends_at' => Carbon::now()->addDay(),
        ]
    );
    $this->browse(function (Browser $browser) {
        $browser->visit(new HomePage)
            ->assertPresent('@title')
            ->assertPresent('@card-link')
            ->assertSeeIn('@card-link', 'This is a test rfc that should be rendered')
            ->assertDontSeeIn('@card-link', 'This is a test rfc that should not be rendered');
    });
});

test('it renders only the newest three open rfcs', function () {
    Rfc::factory()->create(
        [
            'title' => 'This is a test rfc that should not be rendered',
            'published_at' => Carbon::now()->subDays(4),
            'created_at' => Carbon::now()->subDays(4),
            'ends_at' => Carbon::now()->addDay(),

        ]
    );

    Rfc::factory()->create(
        [
            'title' => 'This is a test rfc that should be rendered 1',
            'published_at' => Carbon::now()->subDays(3),
            'created_at' => Carbon::now()->subDays(3),
            'ends_at' => Carbon::now()->addDay(),
        ]
    );

    Rfc::factory()->create(
        [
            'title' => 'This is a test rfc that should be rendered 2',
            'published_at' => Carbon::now()->subDays(2),
            'created_at' => Carbon::now()->subDays(2),
            'ends_at' => Carbon::now()->addDay(),
        ]
    );

    Rfc::factory()->create(
        [
            'title' => 'This is a test rfc that should be rendered 3',
            'published_at' => Carbon::now()->subDays(),
            'created_at' => Carbon::now()->subDays(),
            'ends_at' => Carbon::now()->addDay(),
        ]
    );
    $this->browse(function (Browser $browser) {
        $browser->visit(new HomePage)
            ->assertSee('This is a test rfc that should be rendered 3')
            ->assertSee('This is a test rfc that should be rendered 2')
            ->assertSee('This is a test rfc that should be rendered 1')
            ->assertDontSee('This is a test rfc that should not be rendered');
    });
});

test('it renders open rfcs as links to rfc detail page', function () {
    $rfcTitle = 'This should be a slug';
    Rfc::factory()->create(
        [
            'title' => $rfcTitle,
            'published_at' => Carbon::now()->subDays(3),
            'created_at' => Carbon::now()->subDays(3),
            'ends_at' => Carbon::now()->addDay(),
        ]
    );

    $this->browse(function (Browser $browser) use ($rfcTitle) {
        $browser->visit(new HomePage)
            ->click('@card-link-more')
            ->assertUrlIs(route('rfc-detail', ['rfc' => Str::slug($rfcTitle)]));
    });
});

test('if no argument of the day exists we do not render title and argument', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit(new HomePage)
            ->assertDontSee('Argument of the Day')
            ->assertNotPresent('@argument-card');
    });
});

test('if argument of the day exists we render the title and argument', function () {
    $rfc = Rfc::factory()->create(
        [
            'title' => 'This is a test rfc that should be rendered 1',
            'published_at' => Carbon::now()->subDays(3),
            'created_at' => Carbon::now()->subDays(3),
            'ends_at' => Carbon::now()->addDay(),
        ]
    );
    $argument = Argument::factory()->for($rfc)->create();
    ArgumentVote::factory()->for($argument)->count(10)->create([
        'created_at' => now()->subDay(),
    ]);

    $this->browse(function (Browser $browser) {
        $browser->visit(new HomePage)
            ->assertSee('Argument of the Day')
            ->assertPresent('@argument-card');
    });
});
