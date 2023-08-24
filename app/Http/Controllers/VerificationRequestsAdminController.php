<?php

namespace App\Http\Controllers;

final readonly class VerificationRequestsAdminController
{
    public function __invoke()
    {
        return view('verification-request-admin');
    }
}
