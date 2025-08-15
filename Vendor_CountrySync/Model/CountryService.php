<?php
declare(strict_types=1);

namespace Vendor\CountrySync\Model;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\HTTP\Client\Curl;
use Psr\Log\LoggerInterface;
use Vendor\CountrySync\Api\CountryServiceInterface;

class CountryService implements CountryServiceInterface
{
    private Curl $curl;
    private ResourceConnection $resource;
    private LoggerInterface $logger;

    public function __construct(
        Curl $curl,
        ResourceConnection $resource,
        LoggerInterface $logger
    ) {
        $this->curl = $curl;
        $this->resource = $resource;
        $this->logger = $logger;
    }

    public function syncCountries(): void
    {
        $endpoint = 'https://restcountries.com/v3.1/all';
        try {
            $this->curl->get($endpoint);
            $status = $this->curl->getStatus();
            if ($status !== 200) {
                throw new \RuntimeException('REST call failed with HTTP ' . $status);
            }
            $data = json_decode($this->curl->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\Throwable $e) {
            $this->logger->error('[CountrySync] Error fetching countries: ' . $e->getMessage());
            return;
        }

        $connection = $this->resource->getConnection();
        $tableName = $this->resource->getTableName('vendor_country');

        foreach ($data as $country) {
            $name = $country['name']['common'] ?? null;
            $code = $country['cca2'] ?? null;
            $region = $country['region'] ?? null;

            if (!$name || !$code) {
                continue;
            }

            try {
                $connection->insertOnDuplicate($tableName, [
                    'name' => $name,
                    'code' => strtoupper(substr($code, 0, 2)),
                    'region' => $region
                ], ['name', 'region', 'updated_at']);
            } catch (\Throwable $e) {
                $this->logger->error(sprintf('[CountrySync] Insert failed for %s (%s): %s', $name, $code, $e->getMessage()));
            }
        }
    }
}
