<?php

namespace Tests\Unit;

use App\Actions\SendUserMessage;
use App\Models\Message;
use App\Models\User;
use Tests\TestCase;

class SendUserMessageActionTest extends TestCase
{
    public function test_it_wont_send_a_message_from_the_same_user_to_the_same_user()
    {
        $user = User::factory()->create();

        (new SendUserMessage)($user, $user, '/test', 'Test');

        $this->assertDatabaseMissing(Message::class, [
            'user_id' => $user->id,
            'sender_id' => $user->id,
        ]);
    }
}
