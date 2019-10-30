<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Util\CurrencySources\CurrencySourceInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CurrencySourceConstraintValidator extends ConstraintValidator
{
    /** @var iterable| CurrencySourceInterface[] */
    private $sources;

    /**
     * ContainsCurrencySourceValidator constructor.
     * @param iterable $sources
     */
    public function __construct(iterable $sources)
    {
        $this->sources = $sources;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        foreach ($this->sources as $currencySource) {
            if ($currencySource->getName() === $value) {
                return;
            }
        }

        $this->context->buildViolation($constraint->message)
            ->atPath('source')
            ->addViolation();
    }
}