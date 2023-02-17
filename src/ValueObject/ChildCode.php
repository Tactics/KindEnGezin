<?php

declare(strict_types=1);

namespace Tactics\KindEnGezin\ValueObject;

use DateTimeImmutable;
use Psr\Clock\ClockInterface;
use Tactics\DateTime\ClockAwareDateTime;
use Tactics\DateTime\DateTimePlus;
use Tactics\DateTime\DayOfBirth;
use Tactics\DateTime\Enum\DateTimePlus\FormatWithTimezone;
use Tactics\DateTime\Exception\InvalidDateTimePlus;
use Tactics\DateTime\Exception\InvalidDayOfBirth;
use Tactics\KindEnGezin\Enum\ChildCode\Format;
use Tactics\KindEnGezin\Exception\InvalidChildCode;
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
        private readonly string $code,
        private readonly ?ClockInterface $clock = null
    ) {
        // A child code in plain format must contain only numeric values.
        if (!is_numeric($this->code)) {
            throw InvalidChildCode::nonNumeric();
        }

        // A child code in plain format must be 9 characters long.
        if (mb_strlen($this->code, 'utf8') !== self::LENGTH) {
            throw InvalidChildCode::invalidLength();
        }

        // The first 6 character of the code contains the birthday of the child in the format ymd.
        // We can use DateTime here, since DateTime will silently adjust invalid date (ex: 2022-04-32)
        // So we need to construct a string in ATOM format, so we can use DateTimePlus.
        $datePart = mb_substr($this->code, 0, 6);
        [$year, $month, $day] = str_split($datePart, 2);

        $firstTwoCharCurrentYear = substr((new DateTimeImmutable())->format('Y'), 0, 2);
        try {
            $dateTimePlus = DateTimePlus::from(
                $firstTwoCharCurrentYear . $year . '-' . $month . '-' . $day . 'T12:00:00+00:00',
                FormatWithTimezone::ATOM
            );
        } catch (InvalidDateTimePlus $e) {
            throw InvalidChildCode::invalidDate($e);
        }

        try {
            $date = ClockAwareDateTime::from(
                $dateTimePlus,
                $this->clock
            );
            $this->dayOfBirth = DayOfBirth::from($date);
        } catch (InvalidDayOfBirth $e) {
            throw InvalidChildCode::invalidBirthDay($e);
        }
    }

    public static function from(
        string $code,
        ?ClockInterface $clock = null
    ): ChildCode {
        return new ChildCode(str_replace(['-', ' '], [''], $code), $clock);
    }

    public function format(Format $format): string
    {
        return vsprintf(str_replace('x', '%s', $format->pattern()), str_split($this->code));
    }

    public function dayOfBirth(): DayOfBirth
    {
        return $this->dayOfBirth;
    }
}
