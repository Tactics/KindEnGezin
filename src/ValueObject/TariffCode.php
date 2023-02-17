<?php

declare(strict_types=1);

namespace Tactics\KindEnGezin\ValueObject;

use Psr\Clock\ClockInterface;
use Tactics\KindEnGezin\Enum\TariffCode\Format;
use Tactics\KindEnGezin\Exception\InvalidChildCode;
use Tactics\KindEnGezin\Exception\InvalidTariffCode;
use function mb_strlen;

/**
 * Class TariffCode
 */
final class TariffCode
{
    public const LENGTH = 11;
    private ChildCode $childCode;

    private function __construct(
        private readonly string $code,
        private readonly ?ClockInterface $clock = null
    ) {
        // A tariff code must contain only numeric values.
        if (!is_numeric($this->code)) {
            throw InvalidTariffCode::nonNumeric();
        }

        // A tariff code must be 11 characters long.
        if (mb_strlen($this->code, 'utf8') !== self::LENGTH) {
            throw InvalidTariffCode::invalidLength();
        }

        $childCodePart = substr($this->code, 0, 9);
        try {
            $this->childCode = ChildCode::from($childCodePart, $this->clock);
        } catch (InvalidChildCode $e) {
            throw InvalidTariffCode::invalidChildCode($e);
        }
    }

    public static function from(
        string $code,
        ?ClockInterface $clock = null
    ): TariffCode {
        return new TariffCode(str_replace(['-', ' '], [''], $code), $clock);
    }

    public function format(Format $format): string
    {
        return vsprintf(str_replace('x', '%s', $format->pattern()), str_split($this->code));
    }

    public function childCode(): ChildCode
    {
        return $this->childCode;
    }
}
