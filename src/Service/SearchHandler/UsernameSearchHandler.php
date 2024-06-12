<?php

namespace App\Service\SearchHandler;

use App\Service\Api\DataFetcherInterface;
use App\Service\EmailValidation\Exception\EmailValidationException;
use App\ValueObject\SearchType;
use Psr\Log\LoggerInterface;

final readonly class UsernameSearchHandler implements SearchHandlerInterface
{
    /**
     * @param array<string, DataFetcherInterface> $dataFetchers
     */
    public function __construct(
        private array $dataFetchers,
        private LoggerInterface $logger,
    ) {
    }

    /**
     * @throws EmailValidationException
     */
    public function search(string $searchString): array
    {
        $result = [
            'type' => SearchType::User->value,
        ];

        foreach ($this->dataFetchers as $apiName => $fetcher) {
            $result[$apiName] = $fetcher->fetch($searchString, SearchType::User);
        }

        $this->logger->info(json_encode(array_filter($result)));

        return array_filter($result);
    }
}