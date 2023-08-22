<?php

namespace App\Actions\Importer;

use App\Models\PendingRfc;

readonly class PendingRfcImport
{
    public function __construct(
        private RfcImporter $importer
    ) {

    }

    public function __invoke(
        array $rfcs,
    ): void
    {
        $rfcs = $this->importer->__invoke($rfcs);

        PendingRfc::upsert($rfcs, [
            'title'
        ]);
    }
}
