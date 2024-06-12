<?php

namespace App\Service\Api\DataBreach;

use App\HttpClient\DataBreach\LeakLookupClient;
use App\Service\Api\DataFetcherInterface;
use App\ValueObject\SearchType;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

final readonly class LeakLookupFetcher implements DataFetcherInterface
{
    public function __construct(
        private LeakLookupClient $client,
    ) {
    }

    public function fetch(string $searchString, SearchType $type): array
    {
        try {
            $response = $this->client->request($searchString, $this->getApiType($type));

            $breachSites = json_decode($response->getContent(), true)['message'] ?? [];

            return [
                'breach_sites' => array_keys($breachSites),
            ];
        } catch (HttpExceptionInterface) {
            return [];
        }
    }

    private function getApiType(SearchType $type): string
    {
        return match ($type) {
            SearchType::Email => 'email_address',
            SearchType::User => 'username',
        };
    }
}