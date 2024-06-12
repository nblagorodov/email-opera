<?php

namespace App\HttpClient\SocialNetwork;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final readonly class VKClient
{
    private const ADDITIONAL_FIELDS = ['status', 'bdate', 'city', 'country'];

    public function __construct(
        private HttpClientInterface $client,
        private string $apiKey = '',
        private string $version = '',
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function getUser(string $username): ResponseInterface
    {
        return $this->client->request('GET', 'https://api.vk.ru/method/users.get', [
            'query' => [
                'access_token' => $this->apiKey,
                'v' => $this->version,
                'user_id' => $username,
                'fields' => self::ADDITIONAL_FIELDS,
            ],
        ]);
    }
}