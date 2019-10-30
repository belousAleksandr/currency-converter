<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class CurrencySourceConstraint extends Constraint
{
    public $message = 'Invalid currency source';
}