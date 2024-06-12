<?php

namespace App\Service\SearchHandler;

use App\Service\Api\DataFetcherInterface;
use App\Service\EmailValidation\Exception\EmailValidationException;
use App\Service\EmailValidation\ValidatorInterface;
use App\ValueObject\SearchType;
use Psr\Log\LoggerInterface;

final readonly class EmailSearchHandler implements SearchHandlerInterface
{
    /**
     * @param array<string, DataFetcherInterface> $dataFetchers
     */
    public function __construct(
        private ValidatorInterface $emailValidator,
        private array $dataFetchers,
        private LoggerInterface $logger,
    ) {
    }

    /**
     * @throws EmailValidationException
     */
    public function search(string $searchString): array
    {
        $this->emailValidator->validate($searchString);

        $result = [
            'type' => 'email',
        ];

        foreach ($this->dataFetchers as $apiName => $fetcher) {
            $result[$apiName] = $fetcher->fetch($searchString, SearchType::Email);
        }

        $this->logger->info(json_encode(array_filter($result)));
        return array_filter($result);
    }
}