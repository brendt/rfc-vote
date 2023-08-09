<?php

namespace App\Http\Controllers;

use App\Actions\RenderMetaImage;
use App\Models\Rfc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

final readonly class RfcMetaImageController
{
    public function __invoke(Rfc $rfc, Request $request)
    {
        $html = view('rfc-meta', [
            'rfc' => $rfc,
        ])->render();

        if ($request->has('html')) {
            return $html;
        } elseif ($request->has('nocache')) {
            $image = (new RenderMetaImage())($html);
        } else {
            $image = Cache::remember(
                key: "meta-{$rfc->id}",
                ttl: now()->addMinutes(15),
                callback: fn () => (new RenderMetaImage())($html),
            );
        }

        return response(base64_decode($image))->header('Content-Type', 'image/png');
    }
}
