<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $home = auth()->user()->is_admin ? '/admin' : '/dashboard';

        return redirect()->intended($home);
    }
}
