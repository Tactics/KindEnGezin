<?php

declare(strict_types=1);

namespace Tactics\KindEnGezin\Unit;

use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;
use Psr\Clock\ClockInterface;
use Symfony\Component\Clock\MockClock;
use Tactics\KindEnGezin\Enum\ChildCode\Format;
use Tactics\KindEnGezin\Exception\InvalidChildCode;
use Tactics\KindEnGezin\ValueObject\ChildCode;

final class ChildCodeTest extends TestCase
{
    /**
     * @test
     * @dataProvider fromFormatProvider
     */
    public function child_code(string $code, ?ClockInterface $clock, callable $tests): void
    {
        try {
            $childCode = ChildCode::from($code, $clock);
        } catch (InvalidChildCode $e) {
            $childCode = $e;
        }
        $tests($childCode);
    }


    public function fromFormatProvider(): iterable
    {
        yield 'A child code can not a be less than 9 characters long' => [
            'code' => '12345678',
            'clock' => new MockClock(
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::ATOM,
                    '2023-02-16T12:00:00+00:00'
                )
            ),
            'test' => function (ChildCode|InvalidChildCode $childCode) {
                self::assertInstanceOf(InvalidChildCode::class, $childCode);
                self::assertEquals(InvalidChildCode::INVALID_LENGTH, $childCode->getCode());
            },
        ];

        yield 'A child code can not a be more than 9 characters long' => [
            'code' => '12345678910',
            'clock' => new MockClock(
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::ATOM,
                    '2023-02-16T12:00:00+00:00'
                )
            ),
            'test' => function (ChildCode|InvalidChildCode $childCode) {
                self::assertInstanceOf(InvalidChildCode::class, $childCode);
                self::assertEquals(InvalidChildCode::INVALID_LENGTH, $childCode->getCode());
            },
        ];


        yield 'A child code may contain only number' => [
            'code' => '12A4567B9',
            'clock' => new MockClock(
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::ATOM,
                    '2023-02-16T12:00:00+00:00'
                )
            ),
            'test' => function (ChildCode|InvalidChildCode $childCode) {
                self::assertInstanceOf(InvalidChildCode::class, $childCode);
                self::assertEquals(InvalidChildCode::NON_NUMERIC, $childCode->getCode());
            },
        ];

        yield 'The first 6 characters of a child code must form a valid date (ymd)' => [
            'code' => '221301444',
            'clock' => new MockClock(
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::ATOM,
                    '2023-02-16T12:00:00+00:00'
                )
            ),
            'test' => function (ChildCode|InvalidChildCode $childCode) {
                self::assertInstanceOf(InvalidChildCode::class, $childCode);
                self::assertEquals(InvalidChildCode::INVALID_DATE, $childCode->getCode());
            },
        ];

        yield 'The first 6 characters of a child code must form a valid day of birth (ymd)' => [
            'code' => '220316999',
            'clock' => new MockClock(
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::ATOM,
                    '2022-02-16T12:00:00+00:00'
                )
            ),
            'test' => function (ChildCode|InvalidChildCode $childCode) {
                self::assertInstanceOf(InvalidChildCode::class, $childCode);
                self::assertEquals(InvalidChildCode::INVALID_DAY_OF_BIRTH, $childCode->getCode());
            },
        ];

        yield 'A child code can be created from plain format' => [
            'code' => '220316999',
            'clock' => new MockClock(
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::ATOM,
                    '2023-02-16T12:00:00+00:00'
                )
            ),
            'test' => function (ChildCode|InvalidChildCode $childCode) {
                self::assertEquals('220316999', $childCode->format(Format::PLAIN));
                self::assertEquals('220316-999', $childCode->format(Format::DASHED));
                self::assertEquals('220316 999', $childCode->format(Format::SPACED));
            },
        ];

        yield 'A child code can be created from a dashed format' => [
            'code' => '220316-999',
            'clock' => new MockClock(
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::ATOM,
                    '2023-02-16T12:00:00+00:00'
                )
            ),
            'test' => function (ChildCode|InvalidChildCode $childCode) {
                self::assertEquals('220316999', $childCode->format(Format::PLAIN));
                self::assertEquals('220316-999', $childCode->format(Format::DASHED));
                self::assertEquals('220316 999', $childCode->format(Format::SPACED));
            },
        ];

        yield 'A child code can be created from spaced format' => [
            'code' => '220316 999',
            'clock' => new MockClock(
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::ATOM,
                    '2023-02-16T12:00:00+00:00'
                )
            ),
            'test' => function (ChildCode|InvalidChildCode $childCode) {
                self::assertEquals('220316999', $childCode->format(Format::PLAIN));
                self::assertEquals('220316-999', $childCode->format(Format::DASHED));
                self::assertEquals('220316 999', $childCode->format(Format::SPACED));
            },
        ];

        yield 'A day of birth can be derived from valid child code' => [
            'code' => '220316999',
            'clock' => new MockClock(
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::ATOM,
                    '2023-02-16T12:00:00+00:00'
                )
            ),
            'test' => function (ChildCode|InvalidChildCode $childCode) {
                self::assertEquals('220316', $childCode->dayOfBirth()->toDateTimePlus()->toPhpDateTime()->format('ymd'));
            },
        ];
    }
}
