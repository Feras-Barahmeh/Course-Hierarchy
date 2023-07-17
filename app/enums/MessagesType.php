<?php

namespace App\Enums;

enum MessagesType: int
{
    case Success = 1;
    case Danger = 2;
    case Warning = 3;
    case Info = 4;
}
