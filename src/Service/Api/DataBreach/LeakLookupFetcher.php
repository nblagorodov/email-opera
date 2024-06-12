<?php

namespace App\Service\Api\DataBreach;

use App\HttpClient\DataBreach\EmailRepClient;
use App\HttpClient\DataBreach\LeakLookupClient;
use App\Service\Api\DataFetcherInterface;
use App\ValueObject\SearchType;
use Symfony\Component\HttpFoundation\Response;

final readonly class LeakLookupFetcher implements DataFetcherInterface
{
    public function __construct(
        private LeakLookupClient $client,
    ) {
    }

    public function fetch(string $searchString, SearchType $type): array
    {
        $response = $this->client->request($searchString, $this->getApiType($type));

        $content = json_decode($response->getContent(false), true);

        $success = $content['error'] === "false";
        $breachData = $content['message'] ?? [];

        return [
            'success' => $success,
            'data' => [
                'breaches' => $success && is_array($breachData) ? array_keys($breachData) : [],
            ],
        ];
    }

    private function getApiType(SearchType $type): string
    {
        return match ($type) {
            SearchType::Email => 'email_address',
            SearchType::User => 'username',
        };
    }
}