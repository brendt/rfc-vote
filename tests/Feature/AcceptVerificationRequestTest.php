<?php

use App\Actions\AcceptVerificationRequest;
use App\Http\Controllers\PublicProfileController;
use App\Models\Message;
use App\Models\UserFlair;
use App\Models\VerificationRequest;

test('accept', function () {
    $user = $this->login();

    $request = VerificationRequest::factory()->create([
        'user_id' => $user->id,
    ]);

    $admin = $this->login(isAdmin: true);

    app(AcceptVerificationRequest::class)($request, UserFlair::ADMIN);

    $user->refresh();

    expect($user->flair)->toBe(UserFlair::ADMIN);

    $this->assertDatabaseHas(Message::class, [
        'user_id' => $user->id,
        'sender_id' => $admin->id,
        'url' => action(PublicProfileController::class, $user),
    ]);
});
