<?php

namespace Tactics\KindEnGezin\Enum;

enum DayDivision: string
{
    /**
     * Halve dagen.
     *
     * Voorschoolse opvang, vakantieopvang, snipperdagopvang wordt gepland en gefactureerd met halve dagdelen.
     */
    case HALVES = 'HALVES';

    /**
     * Derde dagen.
     *
     * Opvang na of voor de schooluren voor kinderen die naar school gaan wordt gepland en gefactureerd met derde dagdelen.
     */
    case THIRDS = 'THIRDS';
}
