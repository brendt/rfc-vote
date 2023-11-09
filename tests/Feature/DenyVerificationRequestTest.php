<?php

use App\Actions\DenyVerificationRequest;
use App\Http\Controllers\ProfileController;
use App\Models\Message;
use App\Models\VerificationRequest;

test('deny', function () {
    $user = $this->login();

    $request = VerificationRequest::factory()->create([
        'user_id' => $user->id,
    ]);

    $admin = $this->login(isAdmin: true);

    app(DenyVerificationRequest::class)($request);

    $user->refresh();

    expect($user->flair)->toBeNull();

    $this->assertDatabaseHas(Message::class, [
        'user_id' => $user->id,
        'sender_id' => $admin->id,
        'url' => action([ProfileController::class, 'edit']),
    ]);
});
