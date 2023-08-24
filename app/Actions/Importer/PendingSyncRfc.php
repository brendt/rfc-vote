<?php

namespace App\Actions\Importer;

use Illuminate\Support\Str;

class PendingSyncRfc
{
    private array $metadata;

    private array $rawMetadata;

    private string $text;

    private string $raw;

    private bool $failed = false;

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

    public function setMetadata(array $data): self
    {
        $this->metadata = $data;

        return $this;
    }

    public function metadata(): array
    {
        return $this->metadata;
    }

    public function toArray(): array
    {
        return collect([
            'description' => $this->text
        ])->merge(
            collect($this->metadata)
                ->mapWithKeys(function ($v, $k) {
                    $k = match($k) {
                        'PHP Version' => 'php_version',
                        'Date' => 'created_at',
                        default => Str::snake($k)
                    };

                    return [$k => $k === 'authors' ? json_encode($v) : $v];
                })
                ->only([
                    'description',
                    'authors',
                    'title',
                    'slug',
                    'type',
                    'url',
                    'version',
                    'php_version',
                    'status',
                ])
        )->all();
    }

    public function failed(): bool
    {
        return $this->failed;
    }

    public function fail(): self
    {
        $this->failed = true;

        return $this;
    }
}
