<?php

namespace App\Service\EmailValidation;

class CompositeValidator implements ValidatorInterface
{
    /**
     * @param array<ValidatorInterface> $validators
     */
    public function __construct(
        private readonly array $validators
    ) {
    }

    public function validate(string $emailAddress): void
    {
        foreach ($this->validators as $validator) {
            $validator->validate($emailAddress);
        }
    }
}