<?php

namespace App\Http\Controllers;

use App\Jobs\RenderMetaImageJob;
use App\Models\Rfc;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final readonly class RfcMetaImageController
{
    public function __invoke(Rfc $rfc, Request $request): Response|string
    {
        if ($request->has('html')) {
            return view('rfc-meta', [
                'rfc' => $rfc,
            ])->render();
        }

        if (! $rfc->meta_image || $request->has('nocache')) {
            dispatch_sync(new RenderMetaImageJob($rfc));

            $rfc->refresh();
        }

        return response(base64_decode((string) $rfc->meta_image))->header('Content-Type', 'image/png');
    }
}
