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
                'first_name' => $user['first_name'] ?? '',
                'last_name' => $user['last_name'] ?? '',
                'city' => $user['city']['title'] ?? '',
                'country' => $user['country']['title'] ?? '',
                'status' => $user['status'] ?? '',
                'birth_date' => $user['bdate'] ?? '',
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