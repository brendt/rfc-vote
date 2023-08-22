<?php

namespace App\Console\Commands;

use App\Actions\Importer\PendingRfcImport;
use App\Models\PendingRfc;
use App\Models\Rfc;
use Feed;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class RfcSyncCommand extends Command
{
    protected $signature = 'rfc:sync {rfc? : sdssd} {--force}';

    protected $description = 'Sync all or one rfc';

    public function handle(PendingRfcImport $import): void
    {
        $import(array_filter([$this->argument('rfc')]));

        $this->info('Imported');
    }
}
