<?php

namespace App\Service\Api\SocialNetwork;

use App\HttpClient\SocialNetwork\VKClient;
use App\Service\Api\DataFetcherInterface;
use App\ValueObject\SearchType;

final class VKFetcher extends AbstractFetcher implements DataFetcherInterface
{
    public function __construct(
        private VKClient $client,
        bool $useFakeData,
    ) {
        parent::__construct($useFakeData);
    }

    public function fetch(string $searchString, SearchType $type): array
    {
        try {
            $username = $this->getUsername($searchString, $type);
            $response = $this->client->getUser($username);

            $user = json_decode($response->getContent(), true)['response'][0] ?? [];

            if (!$user) {
                return [];
            }

            return $this->getFetchedData($user);
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
    {
        return [
            'first_name' => $responseData['first_name'] ?? null,
            'last_name' => $responseData['last_name'] ?? null,
            'city' => $responseData['city']['title'] ?? null,
            'country' => $responseData['country']['title'] ?? null,
            'status' => $responseData['status'] ?? null,
            'birth_date' => $responseData['bdate'] ?? null,
        ];
    }

    protected function getFakeFetchedData(array $responseData): array
    {
        return [
            'first_name' => isset($responseData['first_name']) ? $this->faker->firstName : null,
            'last_name' => isset($responseData['last_name']) ? $this->faker->lastName : null,
            'city' => isset($responseData['city']['title']) ? $this->faker->city : null,
            'country' => isset($responseData['country']['title']) ? $this->faker->country : null,
            'status' => isset($responseData['status']) ? $this->faker->sentence : null,
            'birth_date' => isset($responseData['bdate']) ? $this->faker->date : null,
        ];
    }
}