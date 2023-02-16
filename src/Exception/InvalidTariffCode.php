<?php

namespace Tactics\KindEnGezin\Exception;

use LogicException;
use Tactics\KindEnGezin\Enum\TariffCode\Format;
use Tactics\KindEnGezin\ValueObject\TariffCode;

class InvalidTariffCode extends LogicException {

    private const INVALID_LENGTH = 1;

    private const NON_NUMERIC = 2;

    private const INVALID_CODE_FORMAT = 3;

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

    public static function invalidCodeFormat(string $code, Format $format) : self {
        return new self(
            sprintf('the tariff code "%s" is not in the provided format: %s',$code, $format->pattern()),
            self::INVALID_CODE_FORMAT
        );
    }

}
