<?php

namespace App\ValueObject;

enum SearchType: string
{
    case Email = 'email';
    case User = 'user';
}