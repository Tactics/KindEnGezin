<?php

declare(strict_types=1);

namespace Tactics\KindEnGezin\ValueObject;

use Tactics\KindEnGezin\Enum\TariffCode\Format;
use Tactics\KindEnGezin\Enum\ChildCode\Format as ChildCodeFormat;
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
        private readonly string $plain,
    ) {

        // A tariff code must be 11 characters long.
        if (mb_strlen($this->plain, 'utf8') === self::LENGTH) {
            throw InvalidTariffCode::invalidLength();
        }

        // A tariff code must contain only numeric values.
        if (!is_numeric($this->plain)) {
            throw InvalidTariffCode::nonNumeric();
        }

        $childCode = substr($this->plain, 0, 9);
        $this->childCode = ChildCode::fromFormat($childCode, ChildCodeFormat::PLAIN);
    }

    public static function fromFormat(string $code, Format $format): TariffCode
    {
        $formatted = vsprintf(str_replace('x', '%s', $format->pattern()), str_split($code));
        if ($formatted !== $code) {
            throw InvalidTariffCode::invalidCodeFormat($code, $format);
        }

        return match ($format) {
            Format::PLAIN => new self($code),
            Format::DASHED => new self(str_replace(['-'], [''], $code)),
            Format::SPACED => new self(str_replace([' '], [''], $code)),
        };
    }
    public function format(Format $format): string
    {
        return vsprintf(str_replace('x', '%s', $format->pattern()), str_split($this->plain));
    }

    public function childCode(): ChildCode
    {
        return $this->childCode;
    }

}
