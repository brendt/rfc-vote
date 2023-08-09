<?php

namespace App\Console\Commands;

use App\Actions\RenderMetaImage;
use Illuminate\Console\Command;
use Spatie\Browsershot\Browsershot;

class BrowsershotCommand extends Command
{
    protected $signature = 'browsershot';

    public function handle(): void
    {
        $this->info(strlen((new RenderMetaImage())('<h1>hi</h1>')));
    }
}
