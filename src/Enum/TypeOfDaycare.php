<?php

namespace Tactics\KindEnGezin\Enum;

/**
 * Types van kinderopvang.
 *
 * Er zijn 2 soorten opvang:
 * - Gezinsopvang: een kleinschalige opvang waar meestal 1 onthaalouder de kinderen opvangt
 * - Groepsopvang: een grotere opvang waar meerdere kinderbegeleiders de kinderen opvangen.
 *
 * Meerder onthaalouders kunnen ook samenwerken en zo een Groepsopvang vormen.
 *
 * https://www.kindengezin.be/nl/thema/kinderopvang-en-naar-school/zoek-een-opvang/welke-soorten-opvang-zijn-er
 */
enum TypeOfDaycare: string
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
