<?php

namespace Tests\Browser;

use App\Http\Controllers\EnableEmailOptinController;
use App\Models\Argument;
use App\Models\ArgumentVote;
use App\Models\Rfc;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
use Tests\DuskTestCase;

class HomePageTest extends DuskTestCase
{
    use DatabaseTruncation;

    protected function setUp(): void
    {
        parent::setUp();
        Queue::fake(); // generating the meta image for rfcs is expensive
    }

    public function test_it_renders_all_main_sections(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage)
                ->assertPresent('@navbar')
                ->assertPresent('@footer');
        });
    }

    public function test_it_renders_email_notification_disclaimer_to_unauthenticated_users(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage)
                ->assertPresent('@disclaimer')
                ->click('@disclaimer a')
                ->assertUrlIs(route('login'));
        });
    }

    public function test_it_renders_email_notification_disclaimer_for_auth_users_that_didnt_verify_email(): void
    {
        $user = User::factory()->unverified()->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new HomePage)
                ->assertPresent('@disclaimer')
                ->click('@disclaimer a')
                ->assertUrlIs(route('verification.notice'));
        });
    }

    public function test_it_renders_email_notification_disclaimer_for_auth_users_that_do_not_have_email_notifications_enabled(
    ): void {
        $user = User::factory()->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new HomePage)
                ->assertPresent('@disclaimer')
                ->click('@disclaimer a')
                ->assertPathIs('/')
                ->assertSee(EnableEmailOptinController::ENABLED_MESSAGE);
        });
    }

    public function test_it_does_not_render_email_notifications_if_user_already_opted_for_email_notifications(): void
    {
        $user = User::factory()->withEmailOptin()->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new HomePage)
                ->assertNotPresent('@disclaimer');
        });
    }

    public function test_it_renders_open_rfcs_section_even_if_there_are_no_open_rfcs(): void
    {
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
    }

    public function test_it_renders_only_open_rfcs(): void
    {
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
    }

    public function test_it_renders_only_the_newest_three_open_rfcs(): void
    {
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
    }

    public function test_it_renders_open_rfcs_as_links_to_rfc_detail_page(): void
    {
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
    }

    public function test_if_no_argument_of_the_day_exists_we_do_not_render_title_and_argument(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage)
                ->assertDontSee('Argument of the Day')
                ->assertNotPresent('@argument-card');
        });
    }

    public function test_if_argument_of_the_day_exists_we_render_the_title_and_argument(): void
    {
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
    }
}
