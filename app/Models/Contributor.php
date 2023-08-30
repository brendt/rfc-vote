<?php

namespace App\Models;

final class Contributor
{
    public function __construct(
        public int $id,
        public string $name,
        public string $url,
        public array $contributions,
        public ?string $contributionsUrl = null,
    ) {
        $username = pathinfo($this->url, PATHINFO_BASENAME);

        if (! isset($this->contributionsUrl)) {
            $this->contributionsUrl = "https://github.com/brendt/rfc-vote/pulls?q=is%3Apr+author%3A{$username}";
        }
    }
}
