<?php

namespace App\Actions;

use Spatie\Browsershot\Browsershot;

final readonly class RenderMetaImage
{
    public function __invoke(string $html): string
    {
        $browsershot = Browsershot::html($html);

        if ($chromePath = config('services.chrome.path')) {
            $browsershot->setChromePath($chromePath);
        }

        return $browsershot
            ->windowSize(1200, 627)
            ->deviceScaleFactor(2)
            ->setScreenshotType('png')
            ->setCustomTempPath(storage_path())
            ->base64Screenshot();
    }
}
