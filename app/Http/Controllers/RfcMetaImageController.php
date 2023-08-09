<?php

namespace App\Http\Controllers;

use App\Actions\RenderMetaImage;
use App\Models\Rfc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Log;

final readonly class RfcMetaImageController
{
    public function __invoke(Rfc $rfc, Request $request)
    {
        //        if ($request->has('nocache')) {
        //            $image = $this->generateImage($rfc);
        //        } else {
        //            $image = Cache::remember(
        //                key: "meta-{$rfc->id}",
        //                ttl: now()->addMinutes(15),
        //                callback: fn () => $this->generateImage($rfc),
        //            );
        //        }

        $html = view('rfc-meta', [
            'rfc' => Rfc::first(),
        ])->render();

        $image = (new RenderMetaImage())($html);

        return strlen($image);

        return response(base64_decode($image))->header('Content-Type', 'image/png');
    }

    private function generateImage(Rfc $rfc): string
    {
        $html = view('rfc-meta', [
            'rfc' => $rfc,
        ])->render();

        return (new RenderMetaImage())($html);
    }
}
