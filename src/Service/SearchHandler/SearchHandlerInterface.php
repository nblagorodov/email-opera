<?php

namespace App\Service\SearchHandler;

interface SearchHandlerInterface
{
    public function search(string $searchString);
}