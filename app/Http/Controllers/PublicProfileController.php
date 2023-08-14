<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Actions\RequestEmailChange;
use App\Models\EmailChangeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

final readonly class PublicProfileController
{
    public function __invoke(User $user)
    {
        return view('publicProfile', [
            'user' => $user->load([
                'arguments.rfc',
                'argumentVotes.argument.rfc',
                'argumentVotes.argument.user',
            ]),
        ]);
    }
}
