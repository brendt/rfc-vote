<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use ProtoneMedia\LaravelDuskFakes\Mails\PersistentMails;
use Tests\DuskTestCase;

class EmailVerificationTest extends DuskTestCase
{
    use DatabaseTruncation;
    use PersistentMails;

    public function test_it_redirects_users_to_verify_email_page_if_they_are_not_verified(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create([
                'email_verified_at' => null,
            ]);
            $browser->loginAs($user)
                ->visit('/profile')
                ->assertPathIs('/email/verify');
        });
    }

    public function test_it_renders_all_necessary_elements(): void
    {
    }
}
