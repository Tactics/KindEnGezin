<?php

namespace Tactics\KindEnGezin\Exception;

use LogicException;
use Tactics\KindEnGezin\ValueObject\ChildCode;
use Throwable;

class InvalidChildCode extends LogicException
{
    public const INVALID_LENGTH = 1;

    public const NON_NUMERIC = 2;

    public const INVALID_DATE = 3;

    public const INVALID_DAY_OF_BIRTH = 4;

    public static function invalidLength(): self
    {
        return new self(
            sprintf('A child code can only be %s characters long', ChildCode::LENGTH),
            self::INVALID_LENGTH
        );
    }

    public static function nonNumeric(): self
    {
        return new self(
            'A child code can only consist of numeric characters',
            self::NON_NUMERIC
        );
    }

    public static function invalidDate(Throwable|null $previous = null): self
    {
        return new self(
            'The first six digits need to form a valid date',
            self::INVALID_DATE,
            $previous
        );
    }

    public static function invalidBirthDay(Throwable|null $previous = null): self
    {
        return new self(
            'The first six digits need to form a valid day of birth',
            self::INVALID_DAY_OF_BIRTH,
            $previous
        );
    }
}
