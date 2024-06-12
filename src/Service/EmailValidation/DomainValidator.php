<?php

namespace App\Service\EmailValidation;

use App\Service\EmailValidation\Exception\EmailValidationException;

class DomainValidator implements ValidatorInterface
{
    public function validate(string $emailAddress): void
    {
        $domain = explode('@', $emailAddress)[1];

        if (!checkdnsrr($domain, 'MX')) {
            throw new EmailValidationException('address domain doesn’t exist');
        }
    }
}