<?php

namespace App\HttpClient\DataBreach;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final readonly class EmailRepClient
{
    private const API_URL = 'https://emailrep.io';

    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function request(string $email): ResponseInterface
    {
        return $this->client->request('GET', self::API_URL.'/'.$email);
    }
}