<?php

namespace App\Service\Api\SocialNetwork;

use App\HttpClient\SocialNetwork\VKClient;
use App\Service\Api\DataFetcherInterface;
use App\ValueObject\SearchType;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

final readonly class VKFetcher implements DataFetcherInterface
{
    public function __construct(
        private VKClient $client,
    ) {
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

            return [
                'first_name' => $user['first_name'] ?? null,
                'last_name' => $user['last_name'] ?? null,
                'city' => $user['city']['title'] ?? null,
                'country' => $user['country']['title'] ?? null,
                'status' => $user['status'] ?? null,
                'birth_date' => $user['bdate'] ?? null,
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