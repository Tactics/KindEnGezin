<?php

namespace Tactics\KindEnGezin\Enum;

enum ChildCare: string
{
    /**
     * Voorschoolse opvang.
     *
     * Opvang voor kinderen die nog niet naar school gaan.
     */
    case PRE_SCHOOL = 'PRE_SCHOOL';

    /**
     * Buitenschoolse opvang.
     *
     * Opvang na of voor de schooluren voor kinderen die naar school gaan.
     * Dit kan vakantieopvang zijn of opvang door het jaar heen.
     */
    case EXTRACURRICULAR = 'EXTRACURRICULAR';
}
