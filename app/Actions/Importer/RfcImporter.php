<?php

namespace App\Actions\Importer;

use App\Models\PendingRfc;
use Illuminate\Console\Command;

class RfcImporter
{
    public function __invoke(Command $command, array $rfcs = []): void
    {
        $historySections = new GatherSections;

        $sections = $historySections->index();

        if (count($rfcs) === 0) {
            $rfcs = array_keys($sections);
        }

        $numberOfRfcs = count($rfcs);

        $command->info(\Str::plural("Gathering data for {$numberOfRfcs} rfc", $numberOfRfcs));

        PendingRfc::query()->upsert(array_values($sections), ['slug']);
    }

    private function gatherRfcData(string $rfcTitle, array $sections, Command $command)
    {

    }
}
