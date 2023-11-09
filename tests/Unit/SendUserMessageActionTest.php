<?php

use App\Actions\SendUserMessage;
use App\Models\Message;
use App\Models\User;

test('it wont send a message from the same user to the same user', function () {
    $user = User::factory()->create();

    (new SendUserMessage)($user, $user, '/test', 'Test');

    $this->assertDatabaseMissing(Message::class, [
        'user_id' => $user->id,
        'sender_id' => $user->id,
    ]);
});
