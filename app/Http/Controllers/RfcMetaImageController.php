<?php

namespace App\Http\Controllers;

use App\Models\Rfc;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

final readonly class RfcMetaImageController
{
    public function __invoke(Rfc $rfc)
    {
        $html = view('rfc-meta', [
            'rfc' => $rfc,
        ])->render();

        $disk = Storage::disk('public');
        if (! $disk->exists('meta')) {
            $disk->makeDirectory('meta');
        }

        $path = public_path("/storage/meta/{$rfc->id}.jpg");

        Browsershot::html($html)
            ->windowSize(1200, 627)
            ->save($path);

        return response()->file($path);
    }
}
