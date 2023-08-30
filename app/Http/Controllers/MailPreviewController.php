<?php

namespace App\Http\Controllers;

use App\Mail\NewRfcMail;
use App\Models\Rfc;
use App\Models\User;

final readonly class MailPreviewController
{
    public function __invoke(): string
    {
        abort_if(app()->isProduction(), 400);

        $mail = new NewRfcMail(
            rfc: Rfc::query()->findOrFail(1),
            user: User::query()->findOrFail(1),
        );

        return $mail->render();
    }
}
