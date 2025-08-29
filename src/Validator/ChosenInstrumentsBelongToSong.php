<?php

declare(strict_types=1);

namespace App\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class ChosenInstrumentsBelongToSong extends Constraint
{
    public string $message = 'Les instruments choisis ne correspondent pas à ceux disponibles pour ce morceau.';

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

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy(): string
    {
        return static::class.'Validator';
    }
}
