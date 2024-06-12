<?php

namespace App\Service\EmailValidation;

use App\Service\EmailValidation\Exception\EmailValidationException;

class FormatValidator implements ValidatorInterface
{
    public function validate(string $emailAddress): void
    {
        $localPart = explode('@', $emailAddress)[0];

        if ($this->hasInvalidCharacters($localPart)) {
            throw new EmailValidationException('address local part contains invalid characters');
        }
    }

    private function hasInvalidCharacters($emailPart): bool
    {
        return preg_match('/[^a-zA-Z0-9!#$%&\'*+\-\/=?^_`.{|}~]/', $emailPart);
    }
}