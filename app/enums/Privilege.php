<?php

namespace App\Enums;

enum Privilege: int
{
    case Admin = 1;
    case Instructor = 2;
    case Guide = 3;
    case Student = 4;
}
