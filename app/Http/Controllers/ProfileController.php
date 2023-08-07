<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\File;

final readonly class ProfileController
{
    use PasswordValidationRules;

    public function edit()
    {
        $user = auth()->user();

        return view('profile-form', [
            'user' => $user,
        ]);
    }

    public function update(Request $request)
    {
        $validated = collect($request->validate([
            'name' => ['required', 'string'],
            'avatar' => [
                'nullable',
                File::types(['png', 'jpg'])->max(1024),
            ]
        ]));

        $user = $request->user();

        $user->update($validated->except('avatar')->all());

        if ($validated['avatar'] ?? null) {
            $file = $request->file('avatar');

            $path = $file->store(path: 'public/avatars');

            $user->update([
                'avatar' => $path,
            ]);
        }

        return redirect()->action([self::class, 'edit']);
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => ['required', 'string', 'current_password:web'],
            'new_password' => $this->passwordRules(),
        ]);

        $user->forceFill([
            'password' => Hash::make($validated['new_password']),
        ])->save();

        return redirect()->action([self::class, 'edit']);
    }
}
