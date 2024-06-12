<?php

namespace App\Service\Api;

use App\ValueObject\SearchType;

interface DataFetcherInterface
{
    /**
     * @return array<string, mixed>
     */
    public function fetch(string $searchString, SearchType $type): array;
}