<?php

namespace App\Service;

use App\Service\SearchHandler\SearchHandlerInterface;
use App\ValueObject\SearchType;

final readonly class SearchHandlerFactory
{
    /**
     * @param array<string, SearchHandlerInterface> $handlers
     */
    public function __construct(
        private array $handlers = [],
    ) {
    }

    /**
     * @throws \ValueError
     */
    public function create(string $searchString): SearchHandlerInterface
    {
        $type = $this->defineType($searchString);

        return $this->handlers[$type->value];
    }

    /**
     * @throws \ValueError
     */
    private function defineType(string $searchString): SearchType
    {
        $searchParts = explode('@', $searchString);

        if (count($searchParts) > 2 || (!$searchParts[0] && !$searchParts[1])) {
            $this->throwInvalidTypeException();
        }

        if (count($searchParts) === 2 && $searchParts[0] && $searchParts[1]) {
            return SearchType::Email;
        }

        return SearchType::User;
    }

    /**
     * @throws \ValueError
     */
    private function throwInvalidTypeException(): void
    {
        throw new \ValueError('Invalid search string type');
    }
}