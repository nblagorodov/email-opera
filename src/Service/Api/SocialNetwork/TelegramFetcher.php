<?php

namespace App\Service\Api\SocialNetwork;

use App\HttpClient\SocialNetwork\TelegramClient;
use App\Service\Api\DataFetcherInterface;
use App\ValueObject\SearchType;

final class TelegramFetcher extends AbstractFetcher implements DataFetcherInterface
{
    public function __construct(
        private TelegramClient $client,
        bool $useFakeData,
    ) {
        parent::__construct($useFakeData);
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

            return $this->getFetchedData($responseData);
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

    protected function getRealFetchedData(array $responseData): array
    {return [
        'first_name' => $responseData['User']['first_name'] ?? null,
        'last_name' => $responseData['User']['last_name'] ?? null,
        'about' => $responseData['full']['about'] ?? null,
    ];
    }

    protected function getFakeFetchedData(array $responseData): array
    {
        return [
            'first_name' => isset($responseData['User']['first_name']) ? $this->faker->firstName : null,
            'last_name' => isset($responseData['User']['last_name']) ? $this->faker->lastName : null,
            'about' => isset($responseData['full']['about']) ? $this->faker->sentence : null,
        ];
    }
}