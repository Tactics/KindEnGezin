<?php

declare(strict_types=1);

namespace Tactics\KindEnGezin\ValueObject;

use DateTimeImmutable;
use Tactics\DateTime\ClockAwareDate;
use Tactics\DateTime\DayOfBirth;
use Tactics\KindEnGezin\Enum\ChildCode\Format;
use Tactics\KindEnGezin\Exception\InvalidChildCode;
use Throwable;
use function is_numeric;
use function mb_strlen;

/**
 * Class ChildCode
 *
 * @package Kinderopvang\Core\ValueObject\ChildCode
 */
final class ChildCode
{

    public const LENGTH = 9;

    private readonly DayOfBirth $dayOfBirth;

    private function __construct(
        private readonly string $plain,
    ) {
        // A child code in plain format must be 9 characters long.
        if (mb_strlen($this->plain, 'utf8') !== self::LENGTH) {
            throw InvalidChildCode::invalidLength();
        }

        // A child code in plain format must contain only numeric values.
        if (!is_numeric($this->plain)) {
            throw InvalidChildCode::nonNumeric();
        }

        // The first 6 character of the code contains the birthday of the child in the format ymd.
        $datePart = mb_substr($this->plain, 0, 6);
        $datePartAsDateTime = DateTimeImmutable::createFromFormat('ymd', $datePart);
        if (!$datePartAsDateTime instanceof DateTimeImmutable) {
            throw InvalidChildCode::invalidDate();
        }

        try {
            $date = ClockAwareDate::from($datePartAsDateTime);
            $this->dayOfBirth = DayOfBirth::from($date);
        } catch (Throwable $e) {
            throw InvalidChildCode::invalidBirthDay($e);
        }
    }

    public static function fromFormat(string $code, Format $format): ChildCode
    {
        $formatted = vsprintf(str_replace('x', '%s', $format->pattern()), str_split($code));
        if ($formatted !== $code) {
            throw InvalidChildCode::invalidCodeFormat($code, $format);
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

    public function dayOfBirth() : DayOfBirth {
        return $this->dayOfBirth;
    }

}
