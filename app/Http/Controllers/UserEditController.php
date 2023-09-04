<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

final readonly class UserEditController
{
    public function edit(User $user): View
    {
        return view('user-form', [
            'user' => $user,
            'action' => action([self::class, 'update'], ['user' => $user]),
        ]);
    }

    public function update(User $user, UserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_admin'] = isset($data['is_admin']);
        $user->update($data);

        return redirect()->action([self::class, 'edit'], $user)
            ->with('message', 'User details updated successfully.');
    }
}
