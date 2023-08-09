<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Browsershot\Browsershot;

class BrowsershotCommand extends Command
{
    protected $signature = 'browsershot';

    public function handle(): void
    {
        $browsershot = Browsershot::html('<h1>hi</h1>');

        if ($chromePath = config('services.chrome.path')) {
            $browsershot->setChromePath($chromePath);
        }

        $image = $browsershot
            ->windowSize(1200, 627)
            ->deviceScaleFactor(2)
            ->setScreenshotType('png')
            ->setCustomTempPath(storage_path())
            ->base64Screenshot();

        $this->info(strlen($image));
    }
}
