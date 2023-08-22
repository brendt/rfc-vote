<?php

namespace App\Console\Commands;

use App\Actions\Importer\PendingRfcImport;
use Illuminate\Console\Command;

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
