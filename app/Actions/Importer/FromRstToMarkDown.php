<?php

namespace App\Actions\Importer;

use Illuminate\Support\Facades\Process;

class FromRstToMarkDown
{
    private const FILE_HEADER_REGEX = "#^(?:(?:(?:=|-|`|:|\.|'|\"|~|\^|_|\*|\+|\#){2,}\n)?(?:[^\n]+\n)(?:(=|-|`|:|\.|'|\"|~|\^|_|\*|\+|\#){2,}\n)(?:\n+- .+(?=\n\n))??)#sU";

    public function handle(PendingSyncRfc $rfc, \Closure $next)
    {
        if ($rfc->failed()) {
            return $next($rfc);
        }

        return $next($rfc->setRfcText($this->toMarkdown($rfc)));
    }

    private function toMarkdown(PendingSyncRfc $rfc): string
    {
        $content = $this->preProcess($this->toRst($rfc->rawText()));

        $content = $this->toRst($content);
        $content = $this->postProcess($content, $rfc->metadata());

        return $this->fromRstToMarkDown($content);
    }

    private function preProcess(string $content): string
    {
        return $this->removeVotes(
            $this->replaceWikiLineBreaks(
                trim($content),
            ),
        );
    }

    private function postProcess(string $content, array $metadata): string
    {
        return $this->addRfcMetadata(
            $this->convertBlockquotes($content),
            $metadata,
        );
    }

    private function replaceWikiLineBreaks(string $content): string
    {
        // There are instances where folks used the DokuWiki line break to
        // insert an extra line break into the text, presumably for formatting.
        return str_replace("\n\\\\\n", "\n\n", $content);
    }

    /**
     * @link https://www.dokuwiki.org/plugin:doodle4 Doodle Plugin
     */
    private function removeVotes(string $content): string
    {
        $doodlePattern = "#<doodle(?'attributes'[^>]*)>(?'choices'.*)</doodle>#msU";
        $attributesPattern = "#((?'attr'[a-zA-Z]+)=\"(?'value'[^\"]*)\")#msU";

        if (!preg_match_all($doodlePattern, $content, $doodleMatches)) {
            return $content;
        }


        foreach ($doodleMatches[0] as $value) {
            $content = str_replace($value, '', $content);
        }

        return $content;
    }

    /**
     * @link https://www.dokuwiki.org/plugin:blockquote BlockQuote Plugin
     */
    private function convertBlockquotes(string $content): string
    {
        $pattern = '#<blockquote.*>(.*)</blockquote>#msU';

        if (!preg_match_all($pattern, $content, $matches)) {
            return $content;
        }

        $replacements = [];
        foreach ($matches[1] as $match) {
            $temp = trim($match);
            $temp = str_replace("\n\n", '||para||', $temp);
            $temp = str_replace("\n", ' ', $temp);
            $temp = explode('||para||', $temp);

            foreach ($temp as &$para) {
                $para = trim($para);
                $para = wordwrap($para, 68);
                $para = explode("\n", $para);
                foreach ($para as &$p) {
                    $p = '    ' . $p;
                }
                $para = rtrim(implode("\n", $para));
            }

            $replacements[] = implode("\n\n", $temp);
        }

        return str_replace($matches[0], $replacements, $content);
    }

    private function addRfcMetadata(string $content, array $metadata): string
    {
        // Add additional newlines to ensure the header expression matches.
        $content .= "\n\n";

        $adornment = '=';
        $headerFound = preg_match(self::FILE_HEADER_REGEX, $content, $matches);

        if (is_array($matches) && count($matches) > 0) {
            $adornment = $matches[1];
        }

        // Remove the existing header and replace it with the new one.
        // We do several trimming steps here to keep the output clean.
        if ($headerFound > 0) {
            return preg_replace(self::FILE_HEADER_REGEX, '', $content);
        }

        return trim($content) . "\n";
    }

    private function toRst(string $content, string $from = 'dokuwiki'): string
    {
        return Process::command(['pandoc', '--from', $from, '--to', 'rst'])
            ->input($content)
            ->run()
            ->throw()
            ->output();
    }

    private function fromRstToMarkDown(string $content): string
    {
        return Process::command(['pandoc', '--from', 'rst', '--to', 'markdown'])
            ->input($content)
            ->run()
            ->throw()
            ->output();
    }
}
