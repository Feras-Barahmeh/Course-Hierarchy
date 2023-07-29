<?php

namespace App\Core;

class FilterInput
{
    public static function int(&$input)
    {
        return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
    }
    public static function float(&$input)
    {
        return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
    public static function str(&$input): string
    {
        return htmlentities(strip_tags($input), ENT_QUOTES, "UTF-8");
    }
}