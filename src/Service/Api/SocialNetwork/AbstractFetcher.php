<?php

namespace App\Service\Api\SocialNetwork;

use Faker\Generator;

abstract class AbstractFetcher
{
    protected Generator $faker;

    public function __construct(
        private readonly bool $useFakeData,
    ) {
        $this->faker = \Faker\Factory::create();
    }

    protected function getFetchedData(array $responseData): array
    {
        return $this->useFakeData
            ? $this->getFakeFetchedData($responseData)
            : $this->getRealFetchedData($responseData);
    }

    abstract protected function getRealFetchedData(array $responseData): array;

    abstract protected function getFakeFetchedData(array $responseData): array;
}