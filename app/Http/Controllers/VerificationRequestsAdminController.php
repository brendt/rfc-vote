<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

final readonly class VerificationRequestsAdminController
{
    public function __invoke(): View
    {
        return view('verification-request-admin');
    }
}
