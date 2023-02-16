<?php

namespace Tactics\KindEnGezin\Enum\TariffCode;

/**
 * Kind en Gezin laat toe om de tariefcodes op 3 manieren te formatteren.
 */
enum Format: string
{
    case PLAIN = 'xxxxxxxxxxx';
    case DASHED = 'xxxxxx-xxx-xx';
    case SPACED = 'xxxxxx xxx xx';

    public function pattern(): string
    {
        return $this->value;
    }
}
