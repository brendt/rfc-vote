<?php

namespace App\Actions\Importer;

use App\Models\PendingRfc;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Console\Command;

class RfcImporter
{
    public function __invoke(Command $command, array $rfcs = []): array
    {
        $historySections = new GatherSections;

        $sections = $historySections->index();

        if (count($rfcs) === 0) {
            $rfcs = array_keys($sections);
        }

        $numberOfRfcs = count($rfcs);

        $command->info(\Str::plural("Gathering data for {$numberOfRfcs} rfc", $numberOfRfcs));

        $bar = $command->getOutput()->createProgressBar($numberOfRfcs);

        $rfcData = [];

        foreach ($rfcs as $rfc) {
            $this->gatherRfcData($rfc, $sections, $command);


            $bar->advance();
        }

        $bar->finish();

        return $rfcData;
    }

    private function gatherRfcData(string $rfcTitle, array $sections, Command $command)
    {
        Pipeline::send(new PendingSyncRfc($rfcTitle, $sections))
            ->through([
                DownloadRfc::class,
                GatherRfcMetaData::class,
                CleanMetaData::class,
                FromRstToMarkDown::class,
            ])->then(function (PendingSyncRfc $rfc) {
                PendingRfc::query()->upsert([
                    $rfc->toArray()
                ], ['slug']);

                return $rfc;
            });
    }
}
