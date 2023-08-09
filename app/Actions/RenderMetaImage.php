<?php

namespace App\Actions;

use Spatie\Browsershot\Browsershot;

final readonly class RenderMetaImage
{
    public function __invoke(string $html): string
    {
        $browsershot = Browsershot::html($html);

        if ($chromePath = config('services.browsershot.chrome_path')) {
            $browsershot->setChromePath($chromePath);
        }

        if ($nodePath = config('services.browsershot.node_path')) {
            $browsershot->setNodeBinary($nodePath);
        }

        if ($npmPath = config('services.browsershot.npm_path')) {
            $browsershot->setNpmBinary($npmPath);
        }

        return $browsershot
            ->windowSize(1200, 627)
            ->deviceScaleFactor(2)
            ->setScreenshotType('png')
            ->setCustomTempPath(storage_path())
            ->base64Screenshot();
    }
}
