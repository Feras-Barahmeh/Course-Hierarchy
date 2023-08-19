<?php

namespace App\Helper;

use App\Core\Cookie;
use App\Core\Session;
use App\Enums\AcademicYear;
use App\Enums\AcademicYearArabic;
use App\Enums\Language;
use App\Models\CourseModel;
use ReflectionException;

class Handel
{
    use HandsHelper;
    /**
     * Get the display name of an academic year based on its value.
     *
     * This static method retrieves the display name of an academic year based on its value. It takes a single parameter,
     * `$valueYear` (the value of the academic year), and returns a string containing the display name.
     *
     * The method uses the currently selected language, retrieved from either the "language" cookie or the "language" session.
     * It then determines the appropriate enum class based on the language and fetches the property enum using the
     * `getPropertyEnum()` method. The method searches for a matching value in the enum and returns the corresponding display name.
     *
     * @param string $valueYear The value of the academic year.
     *
     * @return string Returns the display name of the academic year.
     * @throws ReflectionException
     */
    public static function getNameYear(string $valueYear): string
    {
        $language = Cookie::get("language") ?? Session::get("language");

        $target = '';

        if ($language == Language::English->value) {
            $years = self::getPropertyEnum(AcademicYear::class, null);
        } else {
            $years = self::getPropertyEnum(AcademicYearArabic::class, null);
        }

        foreach ($years as $value => $year) {
            if (str_contains($valueYear, $value)) {
                $target = self::convertCamelToSpace($year);
                break;
            }
        }

        return $target;
    }

    public static function prepareAcademicYears(): array
    {
        $years = CourseModel::getEnumColumns("Year");
        $new = [];
        $language = Cookie::get("language") ?? Session::get("language");

        if ($language == Language::English->value) {
            foreach ($years as $year) {
                $new[$year] = self::convertCamelToSpace($year);
            }
        } else {
            $yearsAr = self::getPropertyEnum(AcademicYearArabic::class);

            for ($i = 0; $i < count($years); $i++) {
                $new[$years[$i]] = $yearsAr[$i];
            }
        }
        return $new;
    }

}