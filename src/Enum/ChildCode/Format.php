<?php

namespace Tactics\KindEnGezin\Enum\ChildCode;

/**
 * Kind en Gezin laat toe om de kindcode op 3 manieren te formatteren.
 */
enum Format: string
{
    case PLAIN = 'xxxxxxxxx';
    case DASHED = 'xxxxxx-xxx';
    case SPACED = 'xxxxxx xxx';

    public function pattern(): string
    {
        return $this->value;
    }

    public function isInFormat(string $value) : bool {
        $formatted = vsprintf(str_replace('x', '%s', $this->pattern()), str_split($value));
        return $formatted === $value;
    }
}
