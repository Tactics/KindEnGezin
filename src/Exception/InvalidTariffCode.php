<?php

namespace Tactics\KindEnGezin\Exception;

use LogicException;
use Tactics\KindEnGezin\Enum\TariffCode\Format;
use Tactics\KindEnGezin\ValueObject\TariffCode;

class InvalidTariffCode extends LogicException
{
    public const INVALID_LENGTH = 1;

    public const NON_NUMERIC = 2;

    public const INVALID_CHILD_CODE = 3;

    public static function invalidLength(): self
    {
        return new self(
            sprintf('A tariff code must be %s characters long', TariffCode::LENGTH),
            self::INVALID_LENGTH
        );
    }

    public static function nonNumeric(): self
    {
        return new self(
            'A tariff code can only consist of numeric characters',
            self::NON_NUMERIC
        );
    }

    public static function invalidChildCode(InvalidChildCode $previous): self
    {
        return new self(
            sprintf('the tariff code contains an invalid child code due to: %s', $previous->getMessage()),
            self::INVALID_CHILD_CODE,
            $previous
        );
    }
}
