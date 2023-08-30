<?php

namespace Tests\Feature;

use App\Actions\DenyVerificationRequest;
use App\Http\Controllers\ProfileController;
use App\Models\Message;
use App\Models\VerificationRequest;
use Tests\TestCase;

class DenyVerificationRequestTest extends TestCase
{
    /** @test */
    public function test_deny()
    {
        $user = $this->login();

        $request = VerificationRequest::factory()->create([
            'user_id' => $user->id,
        ]);

        $admin = $this->login(isAdmin: true);

        app(DenyVerificationRequest::class)($request);

        $user->refresh();

        $this->assertNull($user->flair);

        $this->assertDatabaseHas(Message::class, [
            'user_id' => $user->id,
            'sender_id' => $admin->id,
            'url' => action([ProfileController::class, 'edit']),
        ]);
    }
}
