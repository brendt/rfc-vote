<?php

namespace App\Actions;

use App\Http\Controllers\ProfileController;
use App\Models\User;
use App\Models\VerificationRequest;
use App\Models\VerificationRequestStatus;

final readonly class DenyVerificationRequest
{
    public function __construct(private SendUserMessage $sendMessage) {}

    public function __invoke(VerificationRequest $request): void
    {
        $request->update([
            'status' => VerificationRequestStatus::DENIED,
        ]);

        /** @var User $authenticatedUser */
        $authenticatedUser = auth()->user();

        ($this->sendMessage)(
            to: $request->user,
            sender: $authenticatedUser,
            url: action([ProfileController::class, 'edit']),
            body: <<<'TXT'
            Unfortunately, your verification request has been denied. You can always reapply on your profile page if you think this was in error.
            TXT,
        );
    }
}
