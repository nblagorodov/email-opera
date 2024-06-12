<?php

namespace App\HttpClient\DataBreach;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final readonly class LeakLookupClient
{
    private const API_URL = 'https://leak-lookup.com/api/search';

    public function __construct(
        private HttpClientInterface $client,
        private string $apiKey = '',
    ) {
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function request(string $searchString, string $type): ResponseInterface
    {
        return $this->client->request('POST', self::API_URL, [
            'body' => [
                'key' => $this->apiKey,
                'type' => $type,
                'query' => $searchString,
            ],
        ]);
    }
}