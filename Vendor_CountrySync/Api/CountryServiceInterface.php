<?php
declare(strict_types=1);

namespace Vendor\CountrySync\Api;

interface CountryServiceInterface
{
    /**
     * Fetch countries from REST API and persist to DB.
     */
    public function syncCountries(): void;
}
