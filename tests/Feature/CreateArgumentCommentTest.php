<?php

use App\Actions\CreateArgumentComment;
use App\Models\Argument;
use App\Models\Message;
use App\Models\Rfc;
use App\Models\User;

test('send', function () {
    [$a, $b, $c] = User::factory()->count(3)->create();

    $rfc = Rfc::factory()->create();

    $argument = Argument::factory()->create([
        'user_id' => $a->id,
        'rfc_id' => $rfc->id,
    ]);

    (new CreateArgumentComment)(
        argument: $argument,
        user: $b,
        body: 'test b',
    );

    // B > A
    $this->assertDatabaseHas('messages', [
        'user_id' => $a->id,
        'sender_id' => $b->id,
    ]);

    // B !> B
    $this->assertDatabaseMissing('messages', [
        'user_id' => $b->id,
    ]);

    // B !> C
    $this->assertDatabaseMissing('messages', [
        'user_id' => $c->id,
        'sender_id' => $b->id,
    ]);

    Message::truncate();
    $argument->refresh();

    (new CreateArgumentComment)(
        argument: $argument,
        user: $c,
        body: 'test c',
    );

    // C > A
    $this->assertDatabaseHas('messages', [
        'user_id' => $a->id,
        'sender_id' => $c->id,
    ]);

    // C > B
    $this->assertDatabaseHas('messages', [
        'user_id' => $b->id,
        'sender_id' => $c->id,
    ]);

    // C !> C
    $this->assertDatabaseMissing('messages', [
        'user_id' => $c->id,
    ]);

    expect($a->refresh()->unread_message_count)->toBe(1);

    Message::truncate();
    $argument->refresh();

    (new CreateArgumentComment)(
        argument: $argument,
        user: $a,
        body: 'test a',
    );

    // A !> A
    $this->assertDatabaseMissing('messages', [
        'user_id' => $a->id,
    ]);

    // A > B
    $this->assertDatabaseHas('messages', [
        'user_id' => $b->id,
        'sender_id' => $a->id,
    ]);

    // A > C
    $this->assertDatabaseHas('messages', [
        'user_id' => $c->id,
        'sender_id' => $a->id,
    ]);

    expect($b->refresh()->unread_message_count)->toBe(1);
    expect($c->refresh()->unread_message_count)->toBe(1);
});
