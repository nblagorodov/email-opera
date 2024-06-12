<?php

namespace App\Service\SearchHandler;

interface SearchHandlerInterface
{
    /**
     * @return array<string, mixed>
     */
    public function search(string $searchString): array;
}