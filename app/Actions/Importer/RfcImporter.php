<?php

namespace App\Actions\Importer;

use Illuminate\Support\Facades\Pipeline;

class RfcImporter
{
    public function __invoke(array $rfcs = []): array
    {
        $historySections = new GatherSections;

        $importData = [];

        $sections = $historySections->index();

        if (count($rfcs) === 0) {
            $rfcs = array_keys($sections);
        }

        foreach ($rfcs as $rfc) {
            $importData[$rfc] = $this->gatherRfcData($rfc, $sections);
        }

        return $importData;
    }

    private function gatherRfcData(string $rfcTitle, array $sections)
    {
        return Pipeline::send(new PendingSyncRfc($rfcTitle, $sections))
            ->through([
                DownloadRfc::class,
                GatherRfcMetaData::class,
                CleanMetaData::class,
                GenerateRfcMarkdownText::class,
            ])->then(fn($rfc) => $rfc->toArray());
    }
}
