<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Mail\EmailVerificationMail;
use App\Models\EmailChangeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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
            'email' => ['required', 'string', 'email', Rule::unique('users', 'email')->ignore($request->user()->id)],
            'website_url' => ['nullable', 'url'],
            'github_url' => ['nullable', 'url'],
            'twitter_url' => ['nullable', 'url'],
            'avatar' => [
                'nullable',
                File::types(['png', 'jpg'])->max(1024),
            ],
        ]));

        $user = $request->user();

        if ($validated['email'] && $validated['email'] !== $user->email) {
            $user->requestEmailChange($validated['email']);
            flash('An email with a verification link has been sent to your new email address. Please click the link to verify your email.');
            return redirect()->action([self::class, 'edit']);
        }

        $user->update($validated->except('avatar')->all());

        if ($validated['avatar'] ?? null) {
            $file = $request->file('avatar');

            $path = $file->store(path: 'public/avatars');

            $user->update([
                'avatar' => $path,
            ]);
        }

        flash('Profile updated successfully');

        return redirect()->action([self::class, 'edit']);
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        if ($user->password) {
            $validated = $request->validate([
                'current_password' => ['required', 'string', 'current_password:web'],
                'new_password' => $this->passwordRules(),
            ]);

            $user->forceFill([
                'password' => Hash::make($validated['new_password']),
            ])->save();

            flash('Password updated successfully');
        } else {
            $validated = $request->validate([
                'password' => $this->passwordRules(),
            ]);

            $user->forceFill([
                'password' => Hash::make($validated['password']),
            ])->save();

            flash('Password set successfully');
        }

        return redirect()->action([self::class, 'edit']);
    }

    public function verifyEmail($token)
    {
        $emailChangeRequest = EmailChangeRequest::where('token', $token)->first();
        if (!$emailChangeRequest) {
            abort('403', 'Email Expired');
        }
        if (now()->greaterThan($emailChangeRequest->created_at->addMinutes(30))) {
            abort('404', 'Link expired');
        }

        $user = $emailChangeRequest->user;
        $user->update(['email' => $emailChangeRequest->new_email]);
        $emailChangeRequest->delete();
        flash('Your email has been successfully changed.');
        return redirect()->action([self::class, 'edit']);
    }

}
