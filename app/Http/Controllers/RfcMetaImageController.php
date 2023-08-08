<?php

namespace App\Http\Controllers;

use App\Models\Rfc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Log;
use Spatie\Browsershot\Browsershot;

final readonly class RfcMetaImageController
{
    public function __invoke(Rfc $rfc, Request $request)
    {
        if ($request->has('nocache')) {
            $image = $this->generateImage($rfc);
        } else {
            $image = Cache::remember(
                key: "meta-{$rfc->id}",
                ttl: now()->addMinutes(15),
                callback: fn () => $this->generateImage($rfc),
            );
        }

        return response(base64_decode($image))->header('Content-Type', 'image/png');
    }

    private function generateImage(Rfc $rfc): string
    {
        $html = view('rfc-meta', [
            'rfc' => $rfc,
        ])->render();

        $browsershot = Browsershot::html($html);

        if ($chromePath = config('services.chrome.path')) {
            $browsershot->setChromePath($chromePath);
        }

        return $browsershot
            ->windowSize(1200, 627)
            ->deviceScaleFactor(2)
            ->setScreenshotType('png')
            ->base64Screenshot();
    }
}
