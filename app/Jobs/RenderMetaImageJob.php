<?php

namespace App\Jobs;

use App\Models\Rfc;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Browsershot\Browsershot;

class RenderMetaImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Rfc $rfc,
    ) {}

    public function handle(Browsershot $browsershot): void
    {
        $html = view('rfc-meta', [
            'rfc' => $this->rfc,
        ])->render();

        $image = $browsershot
            ->setHtml($html)
            ->windowSize(1200, 627)
            ->setScreenshotType('png')
            ->deviceScaleFactor(2)
            ->setCustomTempPath(storage_path())
            ->base64Screenshot();

        $this->rfc->update([
            'meta_image' => $image,
        ]);
    }
}
