<?php

namespace App\Service\Api\SocialNetwork;

use App\HttpClient\SocialNetwork\TelegramClient;
use App\Service\Api\DataFetcherInterface;
use App\ValueObject\SearchType;

final readonly class TelegramFetcher implements DataFetcherInterface
{
    public function __construct(
        private TelegramClient $client,
    ) {
    }

    public function fetch(string $searchString, SearchType $type): array
    {
        try {
            $username = $this->getUsername($searchString, $type);
            $response = $this->client->getFullInfo($username);

            $responseData = json_decode($response->getContent(), true)['response'] ?? [];

            if (!$responseData) {
                return [];
            }

            return [
                'first_name' => $responseData['User']['first_name'] ?? null,
                'last_name' => $responseData['User']['last_name'] ?? null,
                'about' => $user['full']['about'] ?? null,
            ];
        } catch (\Throwable) {
            return [];
        }
    }

    private function getUsername(string $searchString, SearchType $type): string
    {
        if ($type === SearchType::User) {
            return $searchString;
        }

        return current(explode('@', $searchString));
    }
}