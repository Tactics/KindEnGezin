<?php

namespace Tactics\KindEnGezin\Enum;

enum TypeOfChildcare: string
{
    /**
     * Voorschoolse opvang.
     *
     * Opvang voor kinderen die nog niet naar school gaan.
     * Dit is het standaard en meest voorkomende type van opvang.
     */
    case REGULAR = 'REGULAR';

    /**
     * Buitenschoolse opvang.
     *
     * Opvang na of voor de schooluren voor kinderen die naar school gaan.
     */
    case EXTRACURRICULAR = 'EXTRACURRICULAR';

    /**
     * Buitenschoolse opvang in de vakantie.
     *
     * Dit is opvang voor schoolgaande kinderen tijdens de vakantie periodes.
     * Het is enkel een apart concept binnen buitenschoolse opvang sinds
     * de voorschoolse opvang per definitie opvang biedt in de vakantie periodes.
     */
    case EXTRACURRICULAR_HOLIDAY = 'EXTRACURRICULAR_HOLIDAY';

    /**
     * Buitenschoolse opvang op een snipperdag.
     *
     * Dit is opvang voor schoolgaande kinderen tijdens een snipperdag op school.
     * Het is enkel een apart concept binnen buitenschoolse opvang sinds
     * de voorschoolse opvang per definitie de kinderen niet naar school gaan.
     */
    case EXTRACURRICULAR_DAY_OFF = 'EXTRACURRICULAR_DAY_OFF';
}
