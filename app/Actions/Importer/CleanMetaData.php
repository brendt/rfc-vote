<?php

declare(strict_types=1);

namespace App\Actions\Importer;

class CleanMetaData
{
    private const EMAIL_REGEX = '#([\w.\-]+(@| at |\.at\.|\#at\#)[\w.\-]+(( dot | \. )[\w.\-]+)*)#sm';

    private const TYPE_INFORMATIONAL = 'Informational';

    private const TYPE_PROCESS = 'Process';

    private const TYPE_STANDARDS_TRACK = 'Standards Track';

    private const TYPE_UNKNOWN = 'Unknown';

    private const STATUS_ACCEPTED = 'Accepted';

    private const STATUS_ACTIVE = 'Active';

    private const STATUS_DECLINED = 'Declined';

    private const STATUS_DRAFT = 'Draft';

    private const STATUS_IMPLEMENTED = 'Implemented';

    private const STATUS_SUPERSEDED = 'Superseded';

    private const STATUS_UNKNOWN = 'Unknown';

    private const STATUS_VOTING = 'Voting';

    private const STATUS_WITHDRAWN = 'Withdrawn';

    private const STATUS_NORMALIZING_EXPRESSIONS = [
        // These match full strings, so we'll keep them at the top of the list.
        '#^Draft - no content except a very old decision on the topic$#i' => self::STATUS_WITHDRAWN,
        '#^Draft\s?\(Inactive\)$#i' => self::STATUS_WITHDRAWN,
        '#^Meta-RFC$#i' => self::STATUS_DRAFT,
        '#^Partially Accepted \(in PHP 7\.0\)#i' => self::STATUS_ACCEPTED,
        '#^Passed Proposal 1\. 2 and 3 declined\.$#i' => self::STATUS_ACCEPTED,
        '#^Ready for Review & Discussion$#i' => self::STATUS_DRAFT,
        '#^Work in Progress$#i' => self::STATUS_DRAFT,
        '#^in the works$#i' => self::STATUS_DRAFT,
        '#^revising after v1\.0$#i' => self::STATUS_DRAFT,
        '#^updated stream_resolve_include_path\(\) was added in PHP 5\.3\.3$#i' => self::STATUS_IMPLEMENTED,

        // Accepted statuses.
        '#^`?Accepted#i' => self::STATUS_ACCEPTED,

        // Declined statuses.
        '#^(Declined|Rejected)#i' => self::STATUS_DECLINED,

        // Draft statuses.
        '#^(In |Under )?(Development|Discussion|Draft|Brainstorming|Reopened|Started)#i' => self::STATUS_DRAFT,

        // Implemented statuses.
        '#^(<a.*>)?(Applied|Deprecation Implemented|`?Implemented|Merged)#i' => self::STATUS_IMPLEMENTED,

        // Voting statuses.
        '#^(In )?Voting#i' => self::STATUS_VOTING,

        // Withdrawn statuses.
        '#^(Abandonn?ed|Closed|Dead|Inactive|Obsolete|Superseded|Suspended|Wid?thdrawn?)#i' => self::STATUS_WITHDRAWN,
    ];

    private const SECTION_STATUS_MAP = [
        'Declined' => self::STATUS_DECLINED,
        'In Draft' => self::STATUS_DRAFT,
        'Inactive' => self::STATUS_WITHDRAWN,
        'Obsolete' => self::STATUS_WITHDRAWN,
        'PHP 5.3' => self::STATUS_IMPLEMENTED,
        'PHP 5.4' => self::STATUS_IMPLEMENTED,
        'PHP 5.5' => self::STATUS_IMPLEMENTED,
        'PHP 5.6' => self::STATUS_IMPLEMENTED,
        'PHP 7.0' => self::STATUS_IMPLEMENTED,
        'PHP 7.1' => self::STATUS_IMPLEMENTED,
        'PHP 7.2' => self::STATUS_IMPLEMENTED,
        'PHP 7.3' => self::STATUS_IMPLEMENTED,
        'PHP 7.4' => self::STATUS_IMPLEMENTED,
        'PHP 8.0' => self::STATUS_IMPLEMENTED,
        'PHP 8.1' => self::STATUS_IMPLEMENTED,
        'PHP 8.2' => self::STATUS_IMPLEMENTED,
        'PHP 8.3' => self::STATUS_IMPLEMENTED,
        'PHP 8.4' => self::STATUS_IMPLEMENTED,
        'Pending Implementation / Landing' => self::STATUS_ACCEPTED,
        'Process and Policy' => self::STATUS_ACTIVE,
        'Under Discussion' => self::STATUS_DRAFT,
        'Withdrawn' => self::STATUS_WITHDRAWN,
    ];

    private const SECTION_TYPE_MAP = [
        'PHP 5.3' => self::TYPE_STANDARDS_TRACK,
        'PHP 5.4' => self::TYPE_STANDARDS_TRACK,
        'PHP 5.5' => self::TYPE_STANDARDS_TRACK,
        'PHP 5.6' => self::TYPE_STANDARDS_TRACK,
        'PHP 7.0' => self::TYPE_STANDARDS_TRACK,
        'PHP 7.1' => self::TYPE_STANDARDS_TRACK,
        'PHP 7.2' => self::TYPE_STANDARDS_TRACK,
        'PHP 7.3' => self::TYPE_STANDARDS_TRACK,
        'PHP 7.4' => self::TYPE_STANDARDS_TRACK,
        'PHP 8.0' => self::TYPE_STANDARDS_TRACK,
        'PHP 8.1' => self::TYPE_STANDARDS_TRACK,
        'PHP 8.2' => self::TYPE_STANDARDS_TRACK,
        'PHP 8.3' => self::TYPE_STANDARDS_TRACK,
        'PHP 8.4' => self::TYPE_STANDARDS_TRACK,
        'Process and Policy' => self::TYPE_PROCESS,
    ];

    private array $rfcNumbers = [];

    public function __construct(
        private readonly History $revisions
    ) {
    }

    public function handle(PendingSyncRfc $rfc, \Closure $next): array
    {
        $rfcData = $rfc->rawRfcData();

        return $next(
            $rfc->setMetaData($this->cleanAndSanitizeMetadata($rfcData))
        );
    }

    private function cleanAndSanitizeMetadata(array $raw): array
    {
        $clean = [];

        foreach ($raw as $rawKey => $rawValue) {
            if ($rawKey === 'first published at' && str_contains($rawValue, '://wiki.php.net/rfc/'.$raw['slug'])) {
                // If the wiki URL is the same as "first published at," skip it.
                continue;
            }

            $cleanKey = match ($rawKey) {
                'author', 'author of rfc and creator of pr', 'revived author' => 'authors',
                'contributor' => 'contributors',
                'maintainer' => 'maintainers',
                'original author', 'based on previous rfc by', 'author of original patch' => 'original authors',
                'rfc version' => 'version',
                'target version', 'target php version', 'proposed version', 'proposed php version', 'target' => 'PHP version',
                default => $rawKey,
            };

            $cleanValue = match ($cleanKey) {
                'authors', 'contributors', 'original authors', 'maintainers' => $this->parseAuthors($rawValue),
                'date' => $this->parseDates($rawValue),
                'status' => $this->normalizeStatus($rawValue, $raw['section'] ?? null),
                'title' => $this->cleanTitle($rawValue),
                'version', 'PHP version' => $this->parseVersion($rawValue),
                default => $rawValue,
            };

            $clean[ucwords($cleanKey)] = $cleanValue;

            if (
                in_array($cleanKey, ['authors', 'date', 'status', 'version', 'PHP version'])
                && $rawValue !== $cleanValue
            ) {
                if (! isset($clean[ucwords("original $cleanKey")])) {
                    $clean[ucwords("original $cleanKey")] = $rawValue;
                } else {
                    $clean[ucwords("original $rawKey")] = $rawValue;
                }
            }
        }

        // Some RFC pages do not have a Date property. Use the earliest commit
        // date for the RFC in order to sort the RFCs properly.
        if (! array_key_exists('Date', $clean) || $clean['Date'] === '0000-00-00') {
            $clean['Date'] = $this->getEarliestCommitDateForRfc($clean['Slug']);
        }

        if (! array_key_exists('Status', $clean)) {
            $clean['Status'] = 'Unknown';
        }

        $clean['Type'] = $this->determineType($clean['Section'] ?? null, $clean['Title'] ?? null);
        $clean['PHP Version'] = $this->determinePhpVersion(
            $clean['PHP Version'] ?? '',
            $clean['Section'] ?? null,
        );

        // Drop the Section property.
        unset($clean['Section']);

        if (array_key_exists('PHP Version', $clean) && $clean['PHP Version'] === null) {
            unset($clean['PHP Version']);
        }

        if (array_key_exists('PHP Version', $clean) && $clean['Type'] === self::TYPE_UNKNOWN) {
            $clean['Type'] = self::TYPE_STANDARDS_TRACK;
        }

        if (! array_key_exists('Version', $clean) || $clean['Version'] === null) {
            $clean['Version'] = '1.0';
        }

        ksort($clean, SORT_NATURAL);

        return $clean;
    }

    private function cleanTitle(string $title): string
    {
        if (str_starts_with(strtolower($title), 'request for comments:')) {
            $title = trim(substr($title, 21));
        }

        if (str_starts_with(strtolower($title), 'php rfc:')) {
            $title = trim(substr($title, 8));
        }

        if (str_starts_with(strtolower($title), 'php rfc -')) {
            $title = trim(substr($title, 9));
        }

        if (str_starts_with(strtolower($title), 'rfc:')) {
            $title = trim(substr($title, 4));
        }

        return ucwords($title);
    }

    private function parseAuthors(string $authorValue): array
    {
        // If there are any reStructured Text links in the value, remove them.
        $authorValue = preg_replace('#`(.*) <(.*)>`__#msU', '$1', $authorValue);

        // Do some initial clean up to help with parsing email addresses later.
        $authorValue = str_replace(['&lt;', '&gt;', '(', ')', '<', '>', ';'], '', $authorValue);

        $authorsResult = [];
        $orphanedEmails = [];
        $position = 0;

        // Put angle brackets around anything that looks like an email address.
        $authorValue = preg_replace(self::EMAIL_REGEX, '<$1>', $authorValue);

        // Add commas wherever there's a closing angle bracket (>) followed by
        // a space, since this likely means the entry is continuing with another
        // author. If there's an ampersand (&) surrounded by spaces, also add a
        // comma for the same reason.
        $authorValue = str_replace(
            ['> ', ' & ', '/ ', ' - '],
            ['>, ', ', ', ', ', ', '],
            $authorValue,
        );

        $previousEmail = null;
        foreach (explode(',', $authorValue) as $author) {
            // Find the email address and separate it from the name.
            preg_match('#<(.*)>#sm', $author, $matches);
            $name = trim($author);
            $email = trim($matches[1] ?? '');

            if ($position > 0) {
                $previousEmail = $authorsResult[$position - 1]['email'] ?? '';
            }

            if ($email !== '') {
                $name = trim(str_replace("<$email>", '', $name));
            }

            if ($email === '' && preg_match(self::EMAIL_REGEX, $name) === 1 && $previousEmail === '') {
                $orphanedEmails[$position ? $position - 1 : 0] = $name;

                continue;
            }

            if ($name === '' && preg_match(self::EMAIL_REGEX, $email) === 1 && $previousEmail === '') {
                $orphanedEmails[$position ? $position - 1 : 0] = $email;

                continue;
            }

            if ($name === '' && $email === '') {
                continue;
            }

            if ($name) {
                $authorsResult[$position]['name'] = $name;
            }

            if ($email) {
                $authorsResult[$position]['email'] = $email;
            }

            $position++;
        }

        foreach ($orphanedEmails as $position => $email) {
            $authorsResult[$position]['email'] = trim(str_replace('\\@', '@', $email));
        }

        return $authorsResult;
    }

    private function parseDates(string $dateValue): string
    {
        if (preg_match_all('#(\d{4}-\d{2}-\d{2})#', $dateValue, $matches)) {
            sort($matches[1]);

            return $matches[1][0];
        }

        return '0000-00-00';
    }

    private function determinePhpVersion(string $version, ?string $section): ?string
    {
        return $this->parseVersion((string) $section) ?? $this->parseVersion($version);
    }

    private function parseVersion(string $version): ?string
    {
        if (preg_match('#(\d*\.?\d*\.?\d+)#', $version, $matches)) {
            return $matches[1];
        }

        return null;
    }

    private function determineType(?string $section, ?string $title): string
    {
        if (array_key_exists($section, self::SECTION_TYPE_MAP)) {
            return self::SECTION_TYPE_MAP[$section];
        }

        if (
            $title !== null
            && (
                str_starts_with(strtolower($title), 'straw poll:')
                || str_starts_with(strtolower($title), 'poll:')
            )
        ) {
            return self::TYPE_INFORMATIONAL;
        }

        return self::TYPE_UNKNOWN;
    }

    private function normalizeStatus(string $status, ?string $section): string
    {
        // Prefer the status obtained from the sections of the RFC index.
        if (array_key_exists($section, self::SECTION_STATUS_MAP)) {
            return self::SECTION_STATUS_MAP[$section];
        }

        foreach (self::STATUS_NORMALIZING_EXPRESSIONS as $expression => $normalizedStatus) {
            if (preg_match($expression, $status)) {
                return $normalizedStatus;
            }
        }

        return self::STATUS_UNKNOWN;
    }

    private function getEarliestCommitDateForRfc(string $rfcSlug): string
    {
        $date = $this->revisions->gatherEarliestRevisionDate($rfcSlug);

        if (null === $date) {
            return '0000-00-00';
        }

        return $date;
    }
}
