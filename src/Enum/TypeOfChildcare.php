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

}

