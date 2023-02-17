<?php

declare(strict_types=1);

namespace Tactics\KindEnGezin\Unit;

use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;
use Psr\Clock\ClockInterface;
use Symfony\Component\Clock\MockClock;
use Tactics\KindEnGezin\Enum\ChildCode\Format as ChildCodeFormat;
use Tactics\KindEnGezin\Enum\TariffCode\Format;
use Tactics\KindEnGezin\Exception\InvalidTariffCode;
use Tactics\KindEnGezin\ValueObject\TariffCode;

final class TariffCodeTest extends TestCase
{
    /**
     * @test
     * @dataProvider fromFormatProvider
     */
    public function tariff_code_from(string $code, ?ClockInterface $clock, callable $tests): void
    {
        try {
            $tariffCode = TariffCode::from($code, $clock);
        } catch (InvalidTariffCode $e) {
            $tariffCode = $e;
        }
        $tests($tariffCode);
    }


    public function fromFormatProvider(): iterable
    {
        yield 'A tariff code can not a be less than 11 characters long' => [
            'code' => '1234567891',
            'clock' => new MockClock(
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::ATOM,
                    '2023-02-16T12:00:00+00:00'
                )
            ),
            'test' => function (TariffCode|InvalidTariffCode $tariffCode) {
                self::assertInstanceOf(InvalidTariffCode::class, $tariffCode);
                self::assertEquals(InvalidTariffCode::INVALID_LENGTH, $tariffCode->getCode());
            },
        ];

        yield 'A tariff code can not a be more than 11 characters long' => [
            'code' => '123456789112',
            'clock' => new MockClock(
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::ATOM,
                    '2023-02-16T12:00:00+00:00'
                )
            ),
            'test' => function (TariffCode|InvalidTariffCode $tariffCode) {
                self::assertInstanceOf(InvalidTariffCode::class, $tariffCode);
                self::assertEquals(InvalidTariffCode::INVALID_LENGTH, $tariffCode->getCode());
            },
        ];

        yield 'A tariff code may contain only number' => [
            'code' => '12A4567B999',
            'clock' => new MockClock(
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::ATOM,
                    '2023-02-16T12:00:00+00:00'
                )
            ),
            'test' => function (TariffCode|InvalidTariffCode $tariffCode) {
                self::assertInstanceOf(InvalidTariffCode::class, $tariffCode);
                self::assertEquals(InvalidTariffCode::NON_NUMERIC, $tariffCode->getCode());
            },
        ];

        yield 'The first 6 characters of a tariff code must form a valid child code' => [
            'code' => '22222244412',
            'clock' => new MockClock(
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::ATOM,
                    '2023-02-16T12:00:00+00:00'
                )
            ),
            'test' => function (TariffCode|InvalidTariffCode $tariffCode) {
                self::assertInstanceOf(InvalidTariffCode::class, $tariffCode);
                self::assertEquals(InvalidTariffCode::INVALID_CHILD_CODE, $tariffCode->getCode());
            },
        ];

        yield 'A tariff code can be created from valid plain format' => [
            'code' => '22031699911',
            'clock' => new MockClock(
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::ATOM,
                    '2023-02-16T12:00:00+00:00'
                )
            ),
            'test' => function (TariffCode|InvalidTariffCode $tariffCode) {
                self::assertEquals('22031699911', $tariffCode->format(Format::PLAIN));
                self::assertEquals('220316-999-11', $tariffCode->format(Format::DASHED));
                self::assertEquals('220316 999 11', $tariffCode->format(Format::SPACED));
            },
        ];

        yield 'A tariff code can be created from valid dashed format' => [
            'code' => '220316-999-11',
            'clock' => new MockClock(
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::ATOM,
                    '2023-02-16T12:00:00+00:00'
                )
            ),
            'test' => function (TariffCode|InvalidTariffCode $tariffCode) {
                self::assertEquals('22031699911', $tariffCode->format(Format::PLAIN));
                self::assertEquals('220316-999-11', $tariffCode->format(Format::DASHED));
                self::assertEquals('220316 999 11', $tariffCode->format(Format::SPACED));
            },
        ];

        yield 'A tariff code can be created from valid spaced format' => [
            'code' => '220316 999 11',
            'clock' => new MockClock(
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::ATOM,
                    '2023-02-16T12:00:00+00:00'
                )
            ),
            'test' => function (TariffCode|InvalidTariffCode $tariffCode) {
                self::assertEquals('22031699911', $tariffCode->format(Format::PLAIN));
                self::assertEquals('220316-999-11', $tariffCode->format(Format::DASHED));
                self::assertEquals('220316 999 11', $tariffCode->format(Format::SPACED));
            },
        ];

        yield 'A child code can be derived from valid tariff code' => [
            'code' => '22031699901',
            'clock' => new MockClock(
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::ATOM,
                    '2023-02-16T12:00:00+00:00'
                )
            ),
            'test' => function (TariffCode|InvalidTariffCode $tariffCode) {
                self::assertEquals('220316999', $tariffCode->childCode()->format(ChildCodeFormat::PLAIN));
            },
        ];
    }
}
