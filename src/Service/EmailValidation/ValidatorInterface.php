<?php

namespace App\Service\EmailValidation;

use App\Service\EmailValidation\Exception\EmailValidationException;

interface ValidatorInterface
{
    /**
     * @throws EmailValidationException
     */
    public function validate(string $emailAddress): void;
}