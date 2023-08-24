<?php

namespace App\Actions\Importer;

use Illuminate\Support\Facades\Http;

class DownloadRfc
{
    private const url = 'https://wiki.php.net/rfc';

    public function handle(PendingSyncRfc $rfc, $next)
    {
        $response = Http::withHeaders([
            'X-DokuWiki-Do' => 'export_raw',
        ])->get(self::url.'/'.$rfc->name);

        if ($response->failed()) {
            return $next($rfc->fail());
        }

        return $next(
            $rfc->setRawText($response->body())
        );
    }
}
