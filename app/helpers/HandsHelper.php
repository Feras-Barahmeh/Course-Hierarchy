<?php

namespace App\Helper;
class HandsHelper
{
    public static function getContentFile($path): false|string
    {
        return file_get_contents($path);
    }
}