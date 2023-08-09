<?php

namespace App\Console\Commands;

use App\Actions\RenderMetaImage;
use App\Models\Rfc;
use Illuminate\Console\Command;

class BrowsershotCommand extends Command
{
    protected $signature = 'browsershot';

    public function handle(): void
    {
        $html = view('rfc-meta', [
            'rfc' => Rfc::first(),
        ])->render();

        $this->info(strlen((new RenderMetaImage())($html)));
    }
}
