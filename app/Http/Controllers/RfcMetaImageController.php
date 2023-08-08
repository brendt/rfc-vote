<?php

namespace App\Http\Controllers;

use App\Models\Rfc;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

final readonly class RfcMetaImageController
{
    public function __invoke(Rfc $rfc)
    {
        $path = Cache::remember(
            key: "meta-{$rfc->id}",
            ttl: now()->addMinutes(15),
            callback: fn () => $this->generateImage($rfc),
        );

        return response()->file($path);
    }

    private function generateImage(Rfc $rfc): string
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
            ->setChromePath('/opt/homebrew/bin/chromium')
            ->windowSize(1200, 627)
            ->save($path);

        return $path;
    }
}
