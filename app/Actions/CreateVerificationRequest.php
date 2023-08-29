<?php

namespace App\Actions;

use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\VerificationRequestsAdminController;
use App\Models\User;
use App\Models\VerificationRequest;
use App\Models\VerificationRequestStatus;

final readonly class CreateVerificationRequest
{
    public function __construct(private SendUserMessage $sendMessage) {}

    public function __invoke(User $user, string $motivation): void
    {
        VerificationRequest::create([
            'user_id' => $user->id,
            'status' => VerificationRequestStatus::PENDING,
            'motivation' => $motivation,
        ]);

        $admins = User::query()->where('is_admin', true)->get();

        foreach ($admins as $admin) {
            ($this->sendMessage)(
                to: $admin,
                sender: $user,
                url: action(VerificationRequestsAdminController::class),
                body: <<<TXT
                There's a new verification request by {$user->name}.
                TXT,
            );
        }
    }
}
