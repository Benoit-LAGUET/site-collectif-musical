<?php

declare(strict_types=1);

namespace App\Validator;

use App\Entity\Vote;
use App\Entity\Instrument;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ChosenInstrumentsBelongToSongValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof ChosenInstrumentsBelongToSong) {
            throw new UnexpectedTypeException($constraint, ChosenInstrumentsBelongToSong::class);
        }

        if (!$value instanceof Vote) {
            // Not the expected object; ignore
            return;
        }

        $song = $value->getSong();
        if ($song === null) {
            // Another validator should ensure song is set; ignore here
            return;
        }

        $allowed = [];
        foreach ($song->getInstruments() as $instr) {
            $allowed[$instr->getId() ?? spl_object_id($instr)] = true;
        }

        $invalidFound = false;
        foreach ($value->getInstruments() as $chosen) {
            $key = $chosen->getId() ?? spl_object_id($chosen);
            if (!isset($allowed[$key])) {
                $invalidFound = true;
                break;
            }
        }

        if ($invalidFound) {
            $this->context->buildViolation($constraint->message)
                ->atPath('instruments')
                ->addViolation();
        }
    }
}
