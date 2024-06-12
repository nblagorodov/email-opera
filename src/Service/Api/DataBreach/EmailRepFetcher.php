<?php

namespace App\Service\Api\DataBreach;

use App\HttpClient\DataBreach\EmailRepClient;
use App\Service\Api\DataFetcherInterface;
use App\ValueObject\SearchType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

final readonly class EmailRepFetcher implements DataFetcherInterface
{
    public function __construct(
        private EmailRepClient $client,
    ) {
    }

    public function fetch(string $searchString, SearchType $type): array
    {
        try {
            $response = $this->client->request($searchString);
            $content = json_decode($response->getContent(), true);

            return [
                'reputation' => $content['reputation'] ?? null,
                'suspicious' => $content['suspicious'] ?? null,
                'malicious_activity_recent' => $content['details']['malicious_activity_recent'] ?? null,
                'spam' => $content['details']['spam'] ?? null,
                'domain_reputation' => $content['details']['domain_reputation'] ?? null,
            ];
        } catch (\Throwable) {
            return [];
        }
    }
}