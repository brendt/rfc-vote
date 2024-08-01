<?php

namespace App\Actions;

use App\Http\Controllers\PublicProfileController;
use App\Models\User;
use App\Models\UserFlair;
use App\Models\VerificationRequest;
use App\Models\VerificationRequestStatus;

final readonly class AcceptVerificationRequest
{
    public function __construct(private SendUserMessage $sendMessage) {}

    public function __invoke(VerificationRequest $request, UserFlair $flair): void
    {
        $request->update([
            'status' => VerificationRequestStatus::ACCEPTED,
        ]);

        $request->user->update([
            'flair' => $flair,
        ]);

        /** @var User $authenticatedUser */
        $authenticatedUser = auth()->user();

        ($this->sendMessage)(
            to: $request->user,
            sender: $authenticatedUser,
            url: action(PublicProfileController::class, $request->user),
            body: <<<TXT
            Your verification request was accepted! We'll now show the {$flair->value} badge besides your username.
            TXT,
        );
    }
}
