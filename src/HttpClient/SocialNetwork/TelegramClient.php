<?php

namespace App\HttpClient\SocialNetwork;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final readonly class TelegramClient
{
    public function __construct(
        private HttpClientInterface $client,
        private string $apiUrl = '',
    ) {
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getFullInfo(string $username): ResponseInterface
    {
        return $this->client->request('GET', $this->apiUrl.'/api/getFullInfo', [
            'query' => [
                'id' => $username,
            ],
        ]);
    }
}