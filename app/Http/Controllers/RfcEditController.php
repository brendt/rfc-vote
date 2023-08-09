<?php

namespace App\Http\Controllers;

use App\Models\Rfc;
use Illuminate\Http\Request;

final readonly class RfcEditController
{
    public function edit(Rfc $rfc)
    {
        return view('rfc-form', [
            'rfc' => $rfc,
            'action' => action([self::class, 'update'], ['rfc' => $rfc, 'back' => request()->get('back')]),
        ]);
    }

    public function update(Rfc $rfc, Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'teaser' => ['required', 'string'],
            'description' => ['required', 'string'],
            'published_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date'],
            'url' => ['required', 'url'],
        ]);

        $rfc->update($validated);

        flash('Success');

        if ($back = $request->get('back')) {
            return redirect()->to($back);
        }

        return redirect()->action([self::class, 'edit'], $rfc);
    }
}
