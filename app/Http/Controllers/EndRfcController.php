<?php

namespace App\Http\Controllers;

use App\Models\Rfc;

final readonly class EndRfcController
{
    public function __invoke(Rfc $rfc)
    {
        $rfc->update([
            'ends_at' => now(),
        ]);

        return redirect()->action(RfcAdminController::class);
    }
}
