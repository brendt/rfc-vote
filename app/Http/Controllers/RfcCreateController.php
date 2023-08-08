<?php

namespace App\Http\Controllers;

use App\Models\Rfc;
use Illuminate\Http\Request;

final readonly class RfcCreateController
{
    public function create()
    {
        return view('rfc-form', [
            'rfc' => new Rfc(),
            'action' => action([self::class, 'store']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'published_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date'],
            'url' => ['required', 'url'],
        ]);

        $rfc = new Rfc($validated);
        $rfc->save();

        flash('Success');

        return redirect()->action([RfcEditController::class, 'edit'], $rfc);
    }
}
