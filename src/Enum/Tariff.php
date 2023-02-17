<?php

namespace Tactics\KindEnGezin\Enum;

/**
 * Type van opvang tarief.
 *
 * Er zijn 2 soorten tarieven, deze kunnen beide te samen aangeboden worden bij eenzelfde verblijf.
 * Een kind kan wisselen van tarief type op maand basis.
 *
 * https://www.kindengezin.be/nl/thema/kinderopvang-en-naar-school/kostprijs
 */
enum Tariff: string
{
    /**
     * Inkomenstarief (IKT).
     *
     * In de meeste locaties betaal je inkomenstarief:
     * een prijs op basis van je inkomen en gezinssamenstelling.
     *
     * Vraag hiervoor je attest inkomenstarief aan op Mijn Kind en Gezin.
     * Bezorg het attest aan je opvang voor de opvang start. (Kindcode Kind en Gezin)
     *
     * De opvang heeft een attest inkomenstarief nodig om de dagprijs
     * voor de opvang van je kindje te berekenen.
     *
     * https://www.kindengezin.be/nl/thema/kinderopvang-en-naar-school/kostprijs/inkomenstarief
     */
    case BASED_ON_INCOME = 'BASED_ON_INCOME';

    /**
     * Vrije Prijs.
     *
     * Soms bepaalt de opvang zelf welke prijs ze vraagt:
     * een vast bedrag per dag of maand bijvoorbeeld.
     *
     * Betaal je voor kinderopvang een prijs die niet afhangt van je inkomen?
     * Dan krijg je een kinderopvangtoeslag (Groeipakket).
     *
     * https://www.kindengezin.be/nl/thema/kinderopvang-en-naar-school/kostprijs/vrije-prijs
     */
    case NOT_BASED_ON_INCOME = 'NOT_BASED_ON_INCOME';
}
