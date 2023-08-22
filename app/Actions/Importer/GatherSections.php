<?php

declare(strict_types=1);

namespace App\Actions\Importer;

use DOMDocument;
use DOMElement;
use DOMNodeList;
use DOMXPath;
use Illuminate\Support\Facades\Http;
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
    public function index(?string $slug = null)
    {
        $rfcs = $this->addFromRfcsPage([]);
        $rfcs = $this->addOrphanedRfcPages($rfcs);

        array_multisort(array_column($rfcs, 'slug'), SORT_ASC, $rfcs);

        return $rfcs;
    }

    private function getSectionHeading(DOMElement $element): string
    {
        // Crawl up the DOM to find the parent div with class "level2" or "level3."
        do {
            $element = $element?->parentNode;

            if (
                $element instanceof DOMElement
                && $element->tagName === 'div'
                && (
                    $element->getAttribute('class') === 'level2'
                    || $element->getAttribute('class') === 'level3'
                )
            ) {
                break;
            }
        } while ($element !== null);

        // Crawl to previous sibling nodes to find the nearest h2 or h3 tag.
        do {
            $element = $element?->previousSibling;

            if (
                $element instanceof DOMElement
                && (
                    $element->tagName === 'h2'
                    || $element->tagName === 'h3'
                )
            ) {
                break;
            }
        } while ($element !== null);

        if ($element === null) {
            return 'Unknown';
        }

        return trim(str_replace("\n", ' ', $element->nodeValue));
    }

    private function addFromRfcsPage(array $rfcs = null): array
    {
        $body = \Http::withHeaders([
            'X-DokuWiki-Do', 'export_xhtmlbody'
        ])->get('https://wiki.php.net/rfc')
            ->throw()
            ->body();

        return $this->parseRfcs($body, $rfcs, true);
    }

    private function addOrphanedRfcPages(array $rfcs): array
    {
        $body = Http::get('https://wiki.php.net/rfc' . '?do=index&idx=rfc')
            ->throw()
            ->body();

        return $this->parseRfcs($body, $rfcs);
    }

    private function parseRfcs(string $body, array $rfcs, bool $inspectSection = false): array
    {
        $contents = $this->tidy->repairString($body);

        $dom = new DOMDocument();
        @$dom->loadHTML('<?xml encoding="utf-8">' . $contents);

        $xpath = new DOMXPath($dom);

        // Find all <a> tags having a data-wiki-id attribute.
        $links = $xpath->query('//a[@data-wiki-id]');

        if (!$links instanceof DOMNodeList) {
            throw new RuntimeException('Could not find data-wiki-id links on page');
        }

        foreach ($links as $link) {
            $dataWikiId = $link->getAttribute('data-wiki-id');
            if (str_starts_with($dataWikiId, 'rfc:')) {
                $slug = substr($dataWikiId, strlen('rfc:'));

                if (in_array($slug, array_column($rfcs, 'slug'))) {
                    continue;
                }

                $rfcs[$slug] = [
                    'slug' => $slug,
                    'section' => $inspectSection ? $this->getSectionHeading($link) : 'Unknown',
                    'url' => 'https://wiki.php.net/rfc' . '/' . $slug,
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

