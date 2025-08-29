<?php

declare(strict_types=1);

namespace App\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class AtLeastTwoInstruments extends Constraint
{
    public string $message = 'Veuillez choisir au moins deux instruments.';

    public function __construct(
        ?array $options = null,
        ?string $message = null,
        ?array $groups = null,
        mixed $payload = null,
    ) {
        parent::__construct($options ?? [], $groups, $payload);
        if (null !== $message) {
            $this->message = $message;
        }
    }

    public function validatedBy(): string
    {
        return static::class.'Validator';
    }
}
