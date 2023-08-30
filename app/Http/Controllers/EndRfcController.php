<?php

namespace App\Http\Controllers;

use App\Models\Rfc;
use Illuminate\Http\RedirectResponse;

final readonly class EndRfcController
{
    public function __invoke(Rfc $rfc): RedirectResponse
    {
        $rfc->update([
            'ends_at' => now(),
        ]);

        return redirect()->action(RfcAdminController::class);
    }
}
