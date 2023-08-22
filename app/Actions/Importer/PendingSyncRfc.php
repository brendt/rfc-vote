<?php

namespace App\Actions\Importer;

class PendingSyncRfc
{
    private array $metadata;
    private array $rawMetadata;
    private string $text;
    private string $raw;

    public function __construct(public readonly string $name, private array $sections)
    {

    }

    public function setRawRfcData(array $metadata): self
    {
        $this->rawMetadata = $metadata;

        return $this;
    }

    public function setRfcText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function setRawText(string $text): self
    {
        $this->raw = $text;

        return $this;
    }

    public function rawText(): string
    {
        return $this->raw;
    }

    public function sections(): array
    {
        return $this->sections;
    }

    public function rawRfcData(): array
    {
        return $this->rawMetadata;
    }

    public function setMetadata(array $data)
    {
        $this->metadata = $data;

        return $this;
    }
}
