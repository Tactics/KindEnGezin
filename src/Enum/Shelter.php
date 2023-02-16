<?php

namespace Tactics\KindEnGezin\Enum;

/**
 * Types van opvang.
 *
 * Er zijn 2 soorten opvang, gezinsopvang, een kleinschalige opvang waar meestal
 * 1 onthaalouder de kinderen opvangt of Groepsopvang waar meerdere kinderbegeleiders
 * de kinderen opvangen.
 *
 * https://www.kindengezin.be/nl/thema/kinderopvang-en-naar-school/zoek-een-opvang/welke-soorten-opvang-zijn-er
 */
enum Shelter: string
{
    /**
     * Gezinsopvang.
     *
     * Een kleinschalige opvang waar meestal 1 onthaalouder de kinderen opvangt.
     * Er zijn maximum 8 kinderen aanwezig. Vaak in de gezinswoning van de onthaalouder
     */
    case FAMILY = 'FAMILY';

    /**
     * Groepsopvang.
     *
     * Meerdere kinderbegeleiders vangen de kinderen op. Maximum 9 kinderen per begeleider.
     * Meestal in een apart gebouw. Een grotere opvang is opgedeeld in leefgroepen van max. 18 kinderen.
     */
    case GROUP = 'GROUP';

}
