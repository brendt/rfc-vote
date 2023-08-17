<?php

namespace App\Actions;

use App\Jobs\SendNewRfcMailJob;
use App\Models\Rfc;
use App\Models\User;

final readonly class SendNewRfcMails
{
    public function __invoke(Rfc $rfc): void
    {
        $users = User::query()->where('email_optin', true)->get();

        foreach ($users as $user) {
            dispatch(new SendNewRfcMailJob($rfc, $user));
        }
    }
}
