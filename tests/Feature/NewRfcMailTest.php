<?php

namespace Tests\Feature;

use App\Actions\SendUserMail;
use App\Mail\NewRfcMail;
use App\Models\Rfc;
use App\Models\User;
use App\Models\UserMail;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

final class NewRfcMailTest extends TestCase
{
    /** @test */
    public function test_sent_to_the_correct_users()
    {
        Mail::fake();

        [$a, $b, $c] = User::factory()->count(3)->sequence(
            ['email_optin' => true],
            ['email_optin' => true],
            ['email_optin' => false],
        )->create();

        Rfc::factory()->create([
            'title' => 'Test RFC',
        ]);

        Mail::assertSentCount(2);

        $this->assertDatabaseHas('user_mails', [
            'user_id' => $a->id,
            'mail_type' => NewRfcMail::class,
        ]);

        $this->assertDatabaseHas('user_mails', [
            'user_id' => $b->id,
            'mail_type' => NewRfcMail::class,
        ]);

        $this->assertDatabaseMissing('user_mails', [
            'user_id' => $c->id,
            'mail_type' => NewRfcMail::class,
        ]);
    }

    public function test_it_wont_send_email_to_user_that_didnt_opt_in(): void
    {
        Mail::fake();

        $rfc = Rfc::factory()->create([
            'title' => 'Test RFC',
        ]);

        $user = User::factory()->create(['email_optin' => false]);

        (new SendUserMail)(
            user: $user,
            mailable: new NewRfcMail(
                $rfc,
                $user,
            ),
        );

        $this->assertDatabaseMissing('user_mails', [
            'user_id' => $user->id,
            'mail_type' => NewRfcMail::class,
        ]);

        Mail::assertNothingOutgoing();
    }

    public function test_it_wont_send_email_to_user_that_has_already_gotten_it(): void
    {
        Mail::fake();

        $rfc = Rfc::factory()->create([
            'title' => 'Test RFC',
        ]);

        $user = User::factory()->create(['email_optin' => true]);

        UserMail::factory()->create(['user_id' => $user->id, 'mail_type' => NewRfcMail::class]);

        (new SendUserMail)(
            user: $user,
            mailable: new NewRfcMail(
                $rfc,
                $user,
            ),
        );

        Mail::assertNothingOutgoing();
    }

    public function test_it_will_send_emails_for_multiple_created_rfcs(): void
    {
        Mail::fake();

        User::factory()->create(['email_optin' => true]);

        Rfc::factory()->count(3)->sequence(
            ['title' => 'Test RFC 1',],
            ['title' => 'Test RFC 2',],
            ['title' => 'Test RFC 3',],
        )->create();

        Mail::assertSentCount(3);
    }
}
