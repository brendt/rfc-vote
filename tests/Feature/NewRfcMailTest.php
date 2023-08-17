<?php

namespace Feature;

use App\Mail\NewRfcMail;
use App\Models\Rfc;
use App\Models\User;
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
}
