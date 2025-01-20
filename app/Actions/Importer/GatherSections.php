<?php

declare(strict_types=1);

namespace App\Actions\Importer;

use DOMDocument;
use DOMNodeList;
use DOMXPath;
use PhpRfcs\Wiki;
use RuntimeException;
use Tidy;

class GatherSections
{
    private Tidy $tidy;

    public function __construct()
    {
        $this->tidy = $this->initializeTidy();
    }

    public function index(string $slug = null)
    {
        $rfcs = $this->addFromRfcsPage([]);

        array_multisort(array_column($rfcs, 'slug'), SORT_ASC, $rfcs);

        return $rfcs;
    }

    private function addFromRfcsPage(array $rfcs = null): array
    {
        $body = \Http::withHeaders([
            'X-DokuWiki-Do', 'export_xhtmlbody',
        ])->get('https://wiki.php.net/rfc')
            ->throw()
            ->body();

        return $this->parseRfcs($body, $rfcs);
    }

    private function parseRfcs(string $body, array $rfcs): array
    {
        $contents = $this->tidy->repairString($body);

        $dom = new DOMDocument();
        @$dom->loadHTML('<?xml encoding="utf-8">'.$contents);

        $xpath = new DOMXPath($dom);

        // Find all <a> tags having a data-wiki-id attribute.
        $links = $xpath->query('//a[@data-wiki-id]');

        if (! $links instanceof DOMNodeList) {
            throw new RuntimeException('Could not find data-wiki-id links on page');
        }

        foreach ($links as $link) {
            /** @var \DOMElement $link */
            $dataWikiId = $link->getAttribute('data-wiki-id');

            if (str_starts_with($dataWikiId, 'rfc:')) {
                $slug = substr($dataWikiId, strlen('rfc:'));
                $title = str_replace(PHP_EOL, ' ', $link->textContent);

                if (in_array($slug, array_column($rfcs, 'slug'), true)) {
                    continue;
                }

                $rfcs[$slug] = [
                    'slug' => $slug,
                    'title' => $title,
                    'url' => 'https://wiki.php.net/rfc'.'/'.$slug,
                ];
            }
        }

        return $rfcs;
    }

    private function initializeTidy(): Tidy
    {
        return new Tidy(config: [
            'bare' => true,
            'clean' => true,
            'coerce-endtags' => true,
            'drop-empty-elements' => true,
            'drop-empty-paras' => true,
            'enclose-block-text' => true,
            'enclose-text' => true,
            'escape-scripts' => true,
            'fix-backslash' => true,
            'fix-bad-comments' => true,
            'fix-style-tags' => true,
            'fix-uri' => true,
            'hide-comments' => true,
            'indent' => true,
            'literal-attributes' => false,
            'output-xhtml' => false,
            'preserve-entities' => true,
            'punctuation-wrap' => false,
            'quote-ampersand' => true,
            'quote-marks' => true,
            'quote-nbsp' => true,
            'skip-nested' => false,
            'word-2000' => true,
            'wrap' => 1000,
            'wrap-attributes' => false,
            'wrap-sections' => false,
            'vertical-space' => 'auto',
        ], encoding: 'utf8');
    }
}
