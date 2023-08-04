<?php

namespace App\Http\Controllers;

use App\Models\Rfc;

final readonly class PublishRfcController
{
    public function __invoke(Rfc $rfc)
    {
        $rfc->update([
            'published_at' => now(),
        ]);

        return redirect()->action(RfcAdminController::class);
    }
}
