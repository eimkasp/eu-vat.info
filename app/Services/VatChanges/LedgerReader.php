<?php

namespace App\Services\VatChanges;

use Carbon\CarbonImmutable;
use League\Csv\Reader;
use Throwable;

final class LedgerReader
{
    public const COLUMNS = [
        'country',
        'rate_type',
        'old_rate',
        'new_rate',
        'effective_date',
        'announced_date',
        'status',
        'reason',
        'description',
        'source',
        'source_url',
        'official_document',
    ];

    public const RATE_TYPES = ['standard', 'reduced', 'super_reduced', 'parking'];

    public const ENACTED = 'enacted';

    public const ANNOUNCED = 'announced';

    private const SINGLE_RATE_TYPES = ['standard', 'super_reduced', 'parking'];

    private const MAX_STANDARD_RATE_CHANGE = 6.0;

    /**
     * @return list<LedgerRow>
     *
     * @throws InvalidLedgerException
     */
    public function read(string $path): array
    {
        if (! is_file($path)) {
            throw new InvalidLedgerException(["Ledger file not found: {$path}"]);
        }

        $records = Reader::from($path, 'r')->getRecords();
        $records->rewind();

        if (! $records->valid()) {
            throw new InvalidLedgerException(['Ledger is empty; expected the header row.']);
        }

        if ($records->current() !== self::COLUMNS) {
            throw new InvalidLedgerException(['Header must be exactly: '.implode(',', self::COLUMNS)]);
        }

        $rows = [];
        $errors = [];

        for ($records->next(); $records->valid(); $records->next()) {
            $line = $records->key() + 1;
            $record = $records->current();

            if (count($record) !== count(self::COLUMNS)) {
                $errors[] = "Line {$line}: expected ".count(self::COLUMNS).' columns, found '.count($record).'.';

                continue;
            }

            $problems = [];
            $row = $this->parse($line, array_combine(self::COLUMNS, array_map(fn ($value) => trim((string) $value), $record)), $problems);

            if ($problems === [] && $row !== null) {
                $rows[] = $row;

                continue;
            }

            foreach ($problems as $problem) {
                $errors[] = "Line {$line}: {$problem}";
            }
        }

        $errors = [...$errors, ...$this->consistencyErrors($rows)];

        if ($errors !== []) {
            throw new InvalidLedgerException($errors);
        }

        usort($rows, fn (LedgerRow $a, LedgerRow $b) => [$a->effectiveDate, $a->country, $a->rateType] <=> [$b->effectiveDate, $b->country, $b->rateType]);

        return $rows;
    }

    /**
     * @param  array<string, string>  $record
     * @param  list<string>  $problems
     */
    private function parse(int $line, array $record, array &$problems): ?LedgerRow
    {
        if (! preg_match('/^[A-Z]{2}$/', $record['country'])) {
            $problems[] = 'country must be an upper-case ISO 3166-1 alpha-2 code (Greece is GR).';
        }

        if (! in_array($record['rate_type'], self::RATE_TYPES, true)) {
            $problems[] = 'rate_type must be one of '.implode(', ', self::RATE_TYPES).'.';
        }

        foreach (['old_rate', 'new_rate'] as $column) {
            if (! preg_match('/^\d{1,2}(\.\d{1,2})?$/', $record[$column])) {
                $problems[] = "{$column} must be a percentage such as 21 or 13.5.";
            }
        }

        if (! in_array($record['status'], [self::ENACTED, self::ANNOUNCED], true)) {
            $problems[] = 'status must be enacted or announced.';
        }

        $effective = $this->date($record['effective_date']);
        $announced = $record['announced_date'] === '' ? null : $this->date($record['announced_date']);

        if ($effective === null) {
            $problems[] = 'effective_date must be a valid YYYY-MM-DD date.';
        }

        if ($record['announced_date'] !== '' && $announced === null) {
            $problems[] = 'announced_date must be empty or a valid YYYY-MM-DD date.';
        }

        if ($effective && $announced && $announced->greaterThan($effective)) {
            $problems[] = 'announced_date cannot be after effective_date.';
        }

        if ($record['description'] === '' || mb_strlen($record['description']) > 600) {
            $problems[] = 'description is required and limited to 600 characters; state what the new rate applies to.';
        }

        if (preg_match('/^Rate changed from [\d.]+% to [\d.]+%\.?$/', $record['description'])) {
            $problems[] = 'description must explain the change, not repeat the two rates.';
        }

        if ($record['source'] === '' || mb_strlen($record['source']) > 255) {
            $problems[] = 'source (the publisher) is required.';
        }

        if (! $this->isHttpsUrl($record['source_url'])) {
            $problems[] = 'source_url must be an https URL of at most 255 characters.';
        }

        if (mb_strlen($record['official_document']) > 255) {
            $problems[] = 'official_document is limited to 255 characters.';
        }

        if ($record['status'] === self::ENACTED && $record['official_document'] === '') {
            $problems[] = 'official_document (the legal act or official notice) is required for enacted changes.';
        }

        if (is_numeric($record['old_rate']) && is_numeric($record['new_rate'])) {
            $change = abs((float) $record['new_rate'] - (float) $record['old_rate']);

            if ($change === 0.0) {
                $problems[] = 'old_rate and new_rate are identical.';
            }

            if ($record['rate_type'] === 'standard' && $change > self::MAX_STANDARD_RATE_CHANGE) {
                $problems[] = 'a standard-rate change of more than '.self::MAX_STANDARD_RATE_CHANGE.' percentage points is not credible: regional and territorial rates (islands, overseas departments) are not recorded, and a typing error is more likely.';
            }
        }

        if ($problems !== []) {
            return null;
        }

        return new LedgerRow(
            line: $line,
            country: $record['country'],
            rateType: $record['rate_type'],
            oldRate: (float) $record['old_rate'],
            newRate: (float) $record['new_rate'],
            effectiveDate: $effective,
            announcedDate: $announced,
            status: $record['status'],
            reason: $record['reason'] === '' ? null : $record['reason'],
            description: $record['description'],
            source: $record['source'],
            sourceUrl: $record['source_url'],
            officialDocument: $record['official_document'] === '' ? null : $record['official_document'],
        );
    }

    /**
     * @param  list<LedgerRow>  $rows
     * @return list<string>
     */
    private function consistencyErrors(array $rows): array
    {
        $errors = [];
        $seen = [];

        foreach ($rows as $row) {
            if (isset($seen[$row->key()])) {
                $errors[] = "Line {$row->line}: duplicates line {$seen[$row->key()]} (same country, rate_type and effective_date); merge them into one row.";
            }

            $seen[$row->key()] ??= $row->line;
        }

        $chains = [];

        foreach ($rows as $row) {
            if ($row->isEnacted() && in_array($row->rateType, self::SINGLE_RATE_TYPES, true)) {
                $chains[$row->country.'|'.$row->rateType][] = $row;
            }
        }

        foreach ($chains as $chain) {
            usort($chain, fn (LedgerRow $a, LedgerRow $b) => $a->effectiveDate <=> $b->effectiveDate);

            for ($i = 1; $i < count($chain); $i++) {
                if (abs($chain[$i]->oldRate - $chain[$i - 1]->newRate) > 0.001) {
                    $errors[] = "Line {$chain[$i]->line}: old_rate {$chain[$i]->oldRate} does not follow the previous {$chain[$i]->country} {$chain[$i]->rateType} change (line {$chain[$i - 1]->line} ends at {$chain[$i - 1]->newRate}); a change is missing or a rate is mistyped.";
                }
            }
        }

        return $errors;
    }

    private function date(string $value): ?CarbonImmutable
    {
        if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return null;
        }

        try {
            $date = CarbonImmutable::createFromFormat('!Y-m-d', $value);
        } catch (Throwable) {
            return null;
        }

        return $date && $date->toDateString() === $value ? $date : null;
    }

    private function isHttpsUrl(string $value): bool
    {
        return mb_strlen($value) <= 255
            && filter_var($value, FILTER_VALIDATE_URL) !== false
            && str_starts_with($value, 'https://')
            && ! preg_match('/\s/', $value);
    }
}
