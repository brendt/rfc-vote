<?php

namespace App\Models;

final readonly class Contributor
{
    /**
     * @param  array<int, string>  $contributions
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $url,
        public array $contributions,
    ) {
    }
}
