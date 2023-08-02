<?php

namespace App\Enums;

enum Department: String
{
    case Directing = 'Directing';
    case Production = 'Production';
    case Writing = 'Writing';
    case Creator = 'Creator';
    case Crew = 'Crew';
}
