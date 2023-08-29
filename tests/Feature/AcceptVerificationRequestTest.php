<?php

namespace Feature;

use App\Actions\AcceptVerificationRequest;
use App\Http\Controllers\PublicProfileController;
use App\Models\Message;
use App\Models\UserFlair;
use App\Models\VerificationRequest;
use Tests\TestCase;

class AcceptVerificationRequestTest extends TestCase
{
    /** @test */
    public function test_accept()
    {
        $user = $this->login();

        $request = VerificationRequest::factory()->create([
            'user_id' => $user->id,
        ]);

        $admin = $this->login(isAdmin: true);

        app(AcceptVerificationRequest::class)($request, UserFlair::ADMIN);

        $user->refresh();

        $this->assertSame(UserFlair::ADMIN, $user->flair);

        $this->assertDatabaseHas(Message::class, [
            'user_id' => $user->id,
            'sender_id' => $admin->id,
            'url' => action(PublicProfileController::class, $user),
        ]);
    }
}
