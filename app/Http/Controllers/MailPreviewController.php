<?php

namespace App\Http\Controllers;

use App\Mail\NewRfcMail;
use App\Models\Rfc;
use App\Models\User;

final readonly class MailPreviewController
{
    public function __invoke()
    {
        abort_if(app()->isProduction(), 400);

        $mail = new NewRfcMail(
            rfc: Rfc::find(1),
            user: User::find(1),
        );

        return $mail->render();
    }
}
