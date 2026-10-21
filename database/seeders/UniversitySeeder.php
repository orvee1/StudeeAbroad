<?php
namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\University;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class UniversitySeeder extends Seeder
{
    private const ENDPOINT = 'https://query.wikidata.org/sparql';
    private const PAGE_SIZE = 150;

    private array $targetCountries = [
        'New Zealand' => 'NZ',
        'South Korea' => 'KR',
        'Finland' => 'FI',
        'Czech Republic' => 'CZ',
        'Saudi Arabia' => 'SA',
        'Japan' => 'JP',
        'France' => 'FR',
        'Ireland' => 'IE',
        'Lithuania' => 'LT',
        'Romania' => 'RO',
        'Malta' => 'MT',
        'United Arab Emirates' => 'AE',
        'Turkey' => 'TR',
        'Switzerland' => 'CH',
        'Spain' => 'ES',
        'Singapore' => 'SG',
        'Latvia' => 'LV',
        'Italy' => 'IT',
        'India' => 'IN',
        'Belgium' => 'BE',
        'Cyprus' => 'CY',
        'Kyrgyzstan' => 'KG',
        'Sweden' => 'SE',
    ];

    private array $cityAliases = [
        'Czech Republic' => ['pilsen' => 'plzen'],
        'Saudi Arabia' => [
            'mecca' => 'makkah',
            'medina' => 'madinah',
            'sakakah' => 'sakaka',
            'al hofuf' => 'al ahsa',
            'hofuf' => 'al ahsa',
        ],
        'South Korea' => ['jeju city' => 'jeju'],
        'India' => [
            'bengaluru' => 'bangalore',
            'prayagraj' => 'allahabad',
            'mysuru' => 'mysore',
            'belgaum' => 'belagavi',
            'gurgaon' => 'gurugram',
            'calicut' => 'kozhikode',
            'pondicherry' => 'puducherry',
        ],
        'Italy' => [
            'roma' => 'rome',
            'milano' => 'milan',
            'firenze' => 'florence',
            'napoli' => 'naples',
            'venezia' => 'venice',
            'padova' => 'padua',
            'torino' => 'turin',
            'genova' => 'genoa',
        ],
        'Cyprus' => ['lefkosia' => 'nicosia'],
    ];

    public function run(): void
    {
        // This seeder uses columns from the research-metadata migration.
        $requiredMetadataColumns = [
            'external_source', 'external_id', 'data_source_url',
            'ranking_source', 'ranking_year', 'ranking_url',
            'acceptance_rate_year', 'acceptance_rate_source_url',
            'cost_currency', 'cost_year', 'cost_source_url',
        ];

        foreach ($requiredMetadataColumns as $column) {
            if (! Schema::hasColumn('universities', $column)) {
                throw new RuntimeException(
                    "universities.{$column} is missing. Run the university metadata migration first."
                );
            }
        }

        $countries = Country::query()
            ->whereIn('name', array_keys($this->targetCountries))
            ->get()
            ->keyBy('name');

        $missing = array_diff(
            array_keys($this->targetCountries),
            $countries->keys()->all()
        );

        if ($missing !== []) {
            throw new RuntimeException(
                'Run CountrySeeder first. Missing countries: '
                . implode(', ', $missing)
            );
        }

        $cityIndex = $this->buildCityIndex($countries);

        $created = 0;
        $updated = 0;
        $unmatched = 0;
        $failedCountries = [];

        $sortOrder = (int) (
            University::max('sort_order') ?? 0
        ) + 1;

        foreach ($this->targetCountries as $countryName => $iso2) {
            /** @var Country $country */
            $country = $countries->get($countryName);

            $this->command?->info("Fetching {$countryName}...");

            try {
                // Fetch the complete country before writing records.
                $rows = $this->fetchUniversityRows($iso2);
            } catch (Throwable $exception) {
                $failedCountries[] = $countryName;

                $this->command?->warn(
                    "Could not fetch {$countryName}: {$exception->getMessage()}"
                );

                continue;
            }

            foreach (
                $this->groupRowsByUniversity($rows) as $record
            ) {
                $city = $this->resolveCity(
                    $country,
                    $record['locations'],
                    $cityIndex
                );

                if (
                    ! $city
                    || ! $city->state
                    || (int) $city->state->country_id
                        !== (int) $country->id
                ) {
                    $unmatched++;
                    continue;
                }

                $name = $record['official_name']
                    ?: $record['name'];

                if (
                    ! $name
                    || preg_match('/^Q\d+$/', $name)
                ) {
                    continue;
                }

                $university = University::withTrashed()
                    ->where('external_source', 'wikidata')
                    ->where('external_id', $record['qid'])
                    ->first();

                if ($university) {
                    // Never move an existing university between countries.
                    if (
                        (int) $university->country_id
                        !== (int) $country->id
                    ) {
                        $this->command?->warn(
                            "Country conflict for {$name}; skipped."
                        );

                        continue;
                    }
                } else {
                    // Support universities added before this import.
                    $university = University::withTrashed()
                        ->where('city_id', $city->id)
                        ->where('name', $name)
                        ->first();

                    if (
                        $university
                        && $university->external_id
                        && (
                            $university->external_source !== 'wikidata'
                            || $university->external_id !== $record['qid']
                        )
                    ) {
                        $this->command?->warn(
                            "External-ID conflict for {$name}; skipped."
                        );

                        continue;
                    }
                }

                $isNew = $university === null;
                $university ??= new University();

                $sourceUrl =
                    'https://www.wikidata.org/wiki/'
                    . $record['qid'];

                if ($isNew) {
                    $university->fill([
                        'country_id' => $country->id,
                        'state_id' => $city->state->id,
                        'city_id' => $city->id,
                        'name' => $name,
                        'slug' => $this->uniqueSlug(
                            $name,
                            $country,
                            $city
                        ),
                        'sort_order' => $sortOrder++,
                        'is_active' => true,
                        'is_featured' => false,
                        'scholarship_available' => null,
                        'world_ranking' => null,
                        'acceptance_rate' => null,
                        'tuition_min' => null,
                        'tuition_max' => null,
                        'living_cost_min' => null,
                        'living_cost_max' => null,
                        'application_fee' => null,
                        'ranking_source' => null,
                        'ranking_year' => null,
                        'ranking_url' => null,
                        'acceptance_rate_year' => null,
                        'acceptance_rate_source_url' => null,
                        'cost_currency' => null,
                        'cost_year' => null,
                        'cost_source_url' => null,
                    ]);
                }

                $university->external_source = 'wikidata';
                $university->external_id = $record['qid'];
                $university->data_source_url = $sourceUrl;

                // Preserve manually maintained fields on re-import.
                $verified = [
                    'type' => $record['type'],
                    'established_year' => $record['established_year'],
                    'website_url' => $record['website_url'],
                    'email' => $record['email'],
                    'phone' => $record['phone'],
                    'address' => $record['address'],
                ];

                foreach ($verified as $column => $value) {
                    if (
                        $value !== null
                        && blank($university->{$column})
                    ) {
                        $university->{$column} = $value;
                    }
                }

                $description = $this->makeShortDescription(
                    $name,
                    $university->type,
                    $university->established_year,
                    $city->name,
                    $country->name
                );

                if (blank($university->short_description)) {
                    $university->short_description = $description;
                }

                if (blank($university->description)) {
                    $university->description = $description;
                }

                if (blank($university->meta_title)) {
                    $university->meta_title = Str::limit(
                        $name . ' - Study Abroad',
                        255,
                        ''
                    );
                }

                if (blank($university->meta_description)) {
                    $university->meta_description = Str::limit(
                        'Explore '
                        . $name
                        . ' in '
                        . $city->name
                        . ', '
                        . $country->name
                        . '.',
                        500,
                        ''
                    );
                }

                // A Wikidata record is not independent human verification.
                if ($university->trashed()) {
                    $university->restore();
                }

                $university->save();

                if ($isNew) {
                    $created++;
                } else {
                    $updated++;
                }
            }
        }

        $this->command?->info(
            "Done. Created: {$created}; updated: {$updated}; "
            . "unmatched/ambiguous locations: {$unmatched}."
        );

        if ($failedCountries !== []) {
            $this->command?->warn(
                'Fetch failed for: '
                . implode(', ', $failedCountries)
                . '. Retry seeding later.'
            );
        }
    }

    /**
     * @return array<int, array<string, array<int, City>>>
     */
    private function buildCityIndex(Collection $countries): array
    {
        $countryIds = $countries->pluck('id')->all();
        $index = [];

        $cities = City::query()
            ->with('state:id,country_id,name')
            ->whereHas(
                'state',
                fn ($query) => $query->whereIn(
                    'country_id',
                    $countryIds
                )
            )
            ->get();

        foreach ($cities as $city) {
            if (! $city->state) {
                continue;
            }

            $countryId = (int) $city->state->country_id;
            $cityKey = $this->normalize($city->name);

            $index[$countryId][$cityKey][] = $city;
        }

        return $index;
    }

    private function fetchUniversityRows(string $iso2): array
    {
        $rows = [];
        $offset = 0;

        do {
            $response = Http::withHeaders([
                'Accept' => 'application/sparql-results+json',
                'User-Agent' => 'StudeeAbroad-UniversitySeeder/2.0',
            ])
                ->connectTimeout(15)
                ->timeout(90)
                ->retry(3, 2000)
                ->get(self::ENDPOINT, [
                    'query' => $this->sparql(
                        $iso2,
                        self::PAGE_SIZE,
                        $offset
                    ),
                    'format' => 'json',
                ]);

            if (! $response->successful()) {
                throw new RuntimeException(
                    "Wikidata HTTP {$response->status()} for country {$iso2}"
                );
            }

            $batch = $response->json('results.bindings');

            if (! is_array($batch)) {
                throw new RuntimeException(
                    "Unexpected Wikidata response for {$iso2}"
                );
            }

            array_push($rows, ...$batch);
            $offset += self::PAGE_SIZE;
        } while (count($batch) === self::PAGE_SIZE);

        return $rows;
    }

    private function sparql(
        string $iso2,
        int $limit,
        int $offset
    ): string {
        $iso2 = strtoupper(
            preg_replace('/[^A-Z]/i', '', $iso2) ?? ''
        );

        return <<<SPARQL
SELECT DISTINCT
    ?university ?universityLabel ?officialName
    ?instance ?instanceLabel
    ?location ?locationLabel
    ?parentLocation ?parentLocationLabel
    ?grandParentLocation ?grandParentLocationLabel
    ?website ?inception ?email ?phone ?address
WHERE {
    ?country wdt:P297 "{$iso2}" .
    ?university wdt:P17 ?country ;
                wdt:P31/wdt:P279* wd:Q3918 .

    FILTER NOT EXISTS { ?university wdt:P576 ?dissolved . }

    OPTIONAL {
        ?university wdt:P1448 ?officialName .
        FILTER(LANG(?officialName) = "" || LANGMATCHES(LANG(?officialName), "en"))
    }

    OPTIONAL { ?university wdt:P31 ?instance . }

    OPTIONAL {
        VALUES ?locationProperty { wdt:P131 wdt:P159 wdt:P276 }
        ?university ?locationProperty ?location .

        OPTIONAL {
            ?location wdt:P131 ?parentLocation .
            OPTIONAL {
                ?parentLocation wdt:P131 ?grandParentLocation .
            }
        }
    }

    OPTIONAL { ?university wdt:P856 ?website . }
    OPTIONAL { ?university wdt:P571 ?inception . }
    OPTIONAL { ?university wdt:P968 ?email . }
    OPTIONAL { ?university wdt:P1329 ?phone . }
    OPTIONAL { ?university wdt:P6375 ?address . }

    SERVICE wikibase:label {
        bd:serviceParam wikibase:language "en" .
    }
}
ORDER BY ?university ?location ?parentLocation ?grandParentLocation ?instance
LIMIT {$limit}
OFFSET {$offset}
SPARQL;
    }

    private function groupRowsByUniversity(array $rows): array
    {
        $grouped = [];

        foreach ($rows as $row) {
            $qid = $this->qid(
                $this->value($row, 'university')
            );

            if (! $qid) {
                continue;
            }

            if (! isset($grouped[$qid])) {
                $grouped[$qid] = [
                    'qid' => $qid,
                    'name' => $this->value(
                        $row,
                        'universityLabel'
                    ),
                    'official_name' => $this->value(
                        $row,
                        'officialName'
                    ),
                    'type' => null,
                    'established_year' => null,
                    'website_url' => null,
                    'email' => null,
                    'phone' => null,
                    'address' => null,
                    'locations' => [],
                ];
            }

            $record = &$grouped[$qid];

            $record['name'] ??= $this->value(
                $row,
                'universityLabel'
            );

            $record['official_name'] ??= $this->value(
                $row,
                'officialName'
            );

            $record['type'] ??= $this->mapType(
                $this->value($row, 'instanceLabel')
            );

            $record['website_url'] ??= $this->cleanUrl(
                $this->value($row, 'website')
            );

            $record['email'] ??= $this->cleanEmail(
                $this->value($row, 'email')
            );

            $record['phone'] ??= $this->cleanText(
                $this->value($row, 'phone'),
                255
            );

            $record['address'] ??= $this->cleanText(
                $this->value($row, 'address'),
                255
            );

            $year = $this->year(
                $this->value($row, 'inception')
            );

            if (
                $year
                && (
                    ! $record['established_year']
                    || $year < $record['established_year']
                )
            ) {
                $record['established_year'] = $year;
            }

            $location = $this->value(
                $row,
                'locationLabel'
            );

            if ($location) {
                $parent = $this->value(
                    $row,
                    'parentLocationLabel'
                );

                $grandparent = $this->value(
                    $row,
                    'grandParentLocationLabel'
                );

                $locationKey = implode('|', [
                    $this->normalize($location),
                    $this->normalize($parent),
                    $this->normalize($grandparent),
                ]);

                $record['locations'][$locationKey] = [
                    'name' => $location,
                    'parent' => $parent,
                    'grandparent' => $grandparent,
                ];
            }

            unset($record);
        }

        return array_values($grouped);
    }

    /**
     * Resolve a city only when direct matches give
     * one unambiguous result.
     */
    private function resolveCity(
        Country $country,
        array $locations,
        array $cityIndex
    ): ?City {
        $aliases = [];

        foreach (
            $this->cityAliases[$country->name] ?? []
            as $from => $to
        ) {
            $aliases[$this->normalize($from)] =
                $this->normalize($to);
        }

        $matches = [];

        foreach ($locations as $location) {
            $cityKey = $this->normalize(
                $location['name']
            );

            $cityKey = $aliases[$cityKey] ?? $cityKey;

            $candidates = $cityIndex[
                (int) $country->id
            ][$cityKey] ?? [];

            if (count($candidates) > 1) {
                // Match administrative region for duplicate city names.
                $context = array_filter([
                    $this->normalize($location['parent']),
                    $this->normalize($location['grandparent']),
                ]);

                $candidates = array_values(
                    array_filter(
                        $candidates,
                        fn (City $city) => in_array(
                            $this->normalize(
                                $city->state?->name
                            ),
                            $context,
                            true
                        )
                    )
                );
            }

            foreach ($candidates as $city) {
                $matches[(int) $city->id] = $city;
            }
        }

        // Multiple matched cities may represent branch campuses.
        return count($matches) === 1
            ? reset($matches)
            : null;
    }

    private function mapType(?string $instance): ?string
    {
        $type = strtolower($instance ?? '');

        if (str_contains($type, 'private')) {
            return 'Private';
        }

        foreach (
            [
                'public',
                'national university',
                'state university',
                'federal university',
            ]
            as $word
        ) {
            if (str_contains($type, $word)) {
                return 'Public';
            }
        }

        return null;
    }

    private function uniqueSlug(
        string $name,
        Country $country,
        City $city
    ): string {
        $base = Str::slug($name) ?: 'university';

        $countryCode = strtolower(
            $country->iso2 ?: Str::slug($country->name)
        );

        $candidates = [
            $base,
            $base . '-' . $countryCode,
            $base . '-' . Str::slug($city->name),
            $base . '-' . $countryCode . '-' . Str::slug($city->name),
        ];

        foreach ($candidates as $candidate) {
            $slug = Str::limit(
                $candidate,
                255,
                ''
            );

            if (
                ! University::withTrashed()
                    ->where('slug', $slug)
                    ->exists()
            ) {
                return $slug;
            }
        }

        $index = 2;

        do {
            $slug = Str::limit($base, 230, '')
                . '-'
                . $index++;
        } while (
            University::withTrashed()
                ->where('slug', $slug)
                ->exists()
        );

        return $slug;
    }

    private function makeShortDescription(
        string $name,
        ?string $type,
        ?int $year,
        string $city,
        string $country
    ): string {
        $description = $name
            . ' is a '
            . ($type ? strtolower($type) . ' ' : '')
            . 'university in '
            . $city
            . ', '
            . $country;

        if ($year) {
            $description .= ', established in ' . $year;
        }

        return $description . '.';
    }

    private function normalize(?string $value): string
    {
        $text = strtolower(
            Str::ascii($value ?? '')
        );

        $text = str_replace(
            ['&', "'"],
            [' and ', ''],
            $text
        );

        return trim(
            preg_replace(
                '/\s+/',
                ' ',
                preg_replace(
                    '/[^a-z0-9]+/',
                    ' ',
                    $text
                ) ?? ''
            ) ?? ''
        );
    }

    private function qid(?string $url): ?string
    {
        return $url
            && preg_match(
                '~/entity/(Q\d+)$~',
                $url,
                $matches
            )
            ? $matches[1]
            : null;
    }

    private function value(
        array $row,
        string $key
    ): ?string {
        $value = $row[$key]['value'] ?? null;

        return is_string($value) && trim($value) !== ''
            ? trim($value)
            : null;
    }

    private function year(?string $date): ?int
    {
        if (
            ! $date
            || ! preg_match(
                '/^(\d{4})-/',
                $date,
                $matches
            )
        ) {
            return null;
        }

        $year = (int) $matches[1];

        return $year >= 1000
            && $year <= (int) date('Y')
            ? $year
            : null;
    }

    private function cleanUrl(?string $url): ?string
    {
        if (
            ! $url
            || ! filter_var(
                $url,
                FILTER_VALIDATE_URL
            )
        ) {
            return null;
        }

        $scheme = strtolower(
            parse_url($url, PHP_URL_SCHEME) ?? ''
        );

        return in_array(
            $scheme,
            ['http', 'https'],
            true
        )
            ? Str::limit($url, 255, '')
            : null;
    }

    private function cleanEmail(?string $email): ?string
    {
        if (! $email) {
            return null;
        }

        $email = preg_replace(
            '/^mailto:/i',
            '',
            $email
        ) ?? $email;

        return filter_var(
            $email,
            FILTER_VALIDATE_EMAIL
        )
            ? Str::limit($email, 255, '')
            : null;
    }

    private function cleanText(
        ?string $text,
        int $limit
    ): ?string {
        if (! $text) {
            return null;
        }

        $text = trim(
            preg_replace('/\s+/', ' ', $text) ?? $text
        );

        return $text !== ''
            ? Str::limit($text, $limit, '')
            : null;
    }
}
