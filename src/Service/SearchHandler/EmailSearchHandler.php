<?php

namespace App\Service\SearchHandler;

use App\Service\EmailValidation\Exception\EmailValidationException;
use App\Service\EmailValidation\ValidatorInterface;

final readonly class EmailSearchHandler implements SearchHandlerInterface
{
    public function __construct(
        private readonly ValidatorInterface $emailValidator,
    ) {
    }

    /**
     * @throws EmailValidationException
     */
    public function search(string $searchString)
    {
        $this->emailValidator->validate($searchString);
    }
}