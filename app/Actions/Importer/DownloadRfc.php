<?php

namespace App\Actions\Importer;

use Illuminate\Support\Facades\Http;
use PhpRfcs\Wiki;

class DownloadRfc
{
    private const url = "https://wiki.php.net/rfc";

    public function handle(PendingSyncRfc $rfc, $next)
    {
        $text = Http::withHeaders([
            'X-DokuWiki-Do' => 'export_raw'
        ])->get(self::url . '/' . $rfc->name)
            ->throw()->body();

        return $next(
            $rfc->setRawText($text)
        );
    }
}
