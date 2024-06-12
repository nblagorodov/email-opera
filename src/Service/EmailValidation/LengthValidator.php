<?php

namespace App\Service\EmailValidation;

use App\Service\EmailValidation\Exception\EmailValidationException;

class LengthValidator implements ValidatorInterface
{
    public function validate(string $emailAddress): void
    {
        [$localPart, $domain] = explode('@', $emailAddress);

        if (strlen($localPart) > 64) {
            throw new EmailValidationException('address local part length is exceeded');
        }

        if (strlen($domain) > 255) {
            throw new EmailValidationException('address domain part length is exceeded;');
        }
    }
}