<?php

namespace App\Http\Controllers;

use App\Models\Rfc;
use Illuminate\Http\RedirectResponse;

final readonly class PublishRfcController
{
    public function __invoke(Rfc $rfc): RedirectResponse
    {
        $rfc->update([
            'published_at' => now(),
        ]);

        return redirect()->action(RfcAdminController::class);
    }
}
