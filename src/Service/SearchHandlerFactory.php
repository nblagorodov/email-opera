<?php

namespace App\Service;

use App\Service\SearchHandler\SearchHandlerInterface;

final readonly class SearchHandlerFactory
{
    private const EMAIL = 'email';

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

        return $this->handlers[$type];
    }

    /**
     * @throws \ValueError
     */
    private function defineType(string $searchString): string
    {
        $searchParts = explode('@', $searchString);

        if (count($searchParts) > 2 || (!$searchParts[0] && !$searchParts[1])) {
            $this->throwInvalidTypeException();
        }

        if (count($searchParts) === 2 && $searchParts[0] && $searchParts[1]) {
            return self::EMAIL;
        }

        $this->throwInvalidTypeException();
    }

    /**
     * @throws \ValueError
     */
    private function throwInvalidTypeException(): void
    {
        throw new \ValueError('Invalid search string type');
    }
}