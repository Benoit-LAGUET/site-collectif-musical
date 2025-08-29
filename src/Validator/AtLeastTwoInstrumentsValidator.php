<?php

declare(strict_types=1);

namespace App\Validator;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class AtLeastTwoInstrumentsValidator extends ConstraintValidator
{
    /**
     * @param Collection<int, mixed>|array<mixed> $value
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof AtLeastTwoInstruments) {
            throw new UnexpectedTypeException($constraint, AtLeastTwoInstruments::class);
        }

        if ($value === null) {
            // null will be handled by NotBlank if needed; here we simply ignore
            return;
        }

        $count = 0;
        if ($value instanceof Collection) {
            $count = $value->count();
        } elseif (is_iterable($value)) {
            foreach ($value as $_) { $count++; }
        } else {
            // If it's not a collection/array, we can't validate
            return;
        }

        if ($count < 2) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
