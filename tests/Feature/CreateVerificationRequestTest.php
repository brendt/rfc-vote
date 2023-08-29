<?php

namespace Feature;

use App\Actions\CreateVerificationRequest;
use App\Http\Controllers\VerificationRequestsAdminController;
use App\Models\Message;
use App\Models\VerificationRequest;
use Tests\TestCase;

class CreateVerificationRequestTest extends TestCase
{
    /** @test */
    public function test_accept()
    {
        $admin = $this->login(isAdmin: true);
        $user = $this->login();

        app(CreateVerificationRequest::class)(
            user: $user,
            motivation: 'test',
        );

        $user->refresh();

        $this->assertDatabaseHas(VerificationRequest::class, [
            'user_id' => $user->id,
            'motivation' => 'test',
        ]);

        $this->assertDatabaseHas(Message::class, [
            'user_id' => $admin->id,
            'sender_id' => $user->id,
            'url' => action(VerificationRequestsAdminController::class),
        ]);
    }
}
