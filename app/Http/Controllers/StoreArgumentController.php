<?php

namespace App\Http\Controllers;

use App\Models\Rfc;
use Illuminate\Http\Request;

final readonly class StoreArgumentController
{
    public function __invoke(Rfc $rfc, Request $request)
    {
        $validated = $request->validate([
            'body' => ['required', 'string']
        ]);

        $request->user()->saveArgument($rfc, $validated['body']);

        return redirect()->action(RfcDetailController::class, $rfc);
    }
}
