<?php

namespace App\Helper;
use JetBrains\PhpStorm\NoReturn;
use ReflectionClass;
use ReflectionException;

trait HandsHelper
{
    public static function getContentFile($path): false|string
    {
        return file_get_contents($path);
    }

    /**
     * redirect to another page
     * @param string $path destination you want go
     * @return void
     */
    #[NoReturn] public function redirect(string $path): void
    {
        session_write_close();
        header("Location: " . $path);
        exit();
    }

    /**
     * check if url request is the same pass url
     * @param array|string $urls the url you want check, send array if you want check in multi urls
     * @return bool true if the same
     */
    public function compareURL(array|string $urls): bool
    {
        if (is_array($urls)) {
            if (in_array(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), $urls)) {
                return true;
            }
            return false;
        }
        return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) == $urls;
    }
    /**
     * Get the value for a form input field (POST data or object property).
     *
     * This method is used to retrieve the value for a specific form input field. The value is obtained from
     * the POST data if it exists, or from an object property if provided. The method takes three parameters:
     * `$nameAttribute`, `$object`, and `$propertyObject`. The `$nameAttribute` parameter represents the name
     * attribute of the form input field. If the corresponding POST data is available (submitted via a form),
     * the method returns the value from the POST data. If not, the method checks if an `$object` instance is
     * provided. If `$object` is null, an empty string is returned. If `$object` is not null, the method checks
     * if `$propertyObject` is provided. If `$propertyObject` is provided, the method returns the value of the
     * specified property from the `$object` instance. If `$propertyObject` is not provided, the method returns
     * the value of the property matching the `$nameAttribute` from the `$object` instance.
     *
     * @param string $nameAttribute The name attribute of the form input field.
     * @param mixed $object (Optional) An object instance from which to retrieve the property value.
     * @param string $propertyObject (Optional) The name of the property to retrieve from the object instance.
     *
     * @return mixed|null The value of the form input field from POST data, object property, or null if not found.
     * @version 1.2
     */
    public function getStorePost($nameAttribute, $object = null, $propertyObject=null): mixed
    {
        if (isset($_POST[$nameAttribute])) {
            return $_POST[$nameAttribute];
        }

        if (is_null($object)) {
            return '';
        }

        if (!is_null($propertyObject)) {
            return $object->$propertyObject;
        }

        return $object->$nameAttribute;
//        return $_POST[$nameAttribute] ?? (is_null($object) ? '' : $object->$nameAttribute);
    }

    /**
     * @param string $string
     * @return string|false
     * @version 1.0
     * To splitting camel case string to words
     * For example
     * word = splitCamelCase The Output is [split, Camel, Case]
     * @author Feras Barahmeh
     */
    public static function convertCamelToSpace(string $string): string|false
    {
        $arr = preg_split(
            '/(^[^A-Z]+|[A-Z][^A-Z]+)/',
            $string,
            -1, /* no limit for replacement count */
            PREG_SPLIT_NO_EMPTY /*don't return empty elements*/
            | PREG_SPLIT_DELIM_CAPTURE /*don't strip anything from output array*/
        );

        return $arr ? implode(' ', $arr) : false;
    }

    /**
     * get position last ward in string
     * @param string $str target text
     * @return int position
     */
    public static function posLastWord(string $str): int
    {
        $str = rtrim($str);

        $len = strlen($str);


        $i = $len - 1;
        for (; $i >= 0; $i--) {
            if (ctype_space($str[$i])) {
                break;
            }
        }
        return $i;
    }
    /**
     * remove last ward from string
     * @param string $str the text you want remove last word from it
     * @return void
     */
    public static function removeLastWord(string &$str): void
    {
        $str = substr($str, 0, self::posLastWord($str));
    }
    /**
     * Remove last character from string
     * @param string $str the text you want remove last word from it
     * @return void
     */
    public static function removeLastChar(string &$str): void
    {
        $str = trim($str);
        $str = substr($str, 0, strlen($str) - 1);
    }

    /**
     * Get last word from string
     * @param string $str the text you want remove last word from it
     * @return string last word
     */
    public static function getLastWord($str): string
    {
        return substr($str, self::posLastWord($str), strlen($str));
    }

    /**
     * encrypt string
     * @param string $str
     * @return string encrypted string
     */
    public static function encryption(string $str): string
    {
        return crypt($str, MAIN_SALT);
    }

    /**
     * Verify if a non-encrypted string matches the encrypted string.
     *
     * This method takes a non-encrypted string and an encrypted string, and it verifies
     * if the non-encrypted string matches the encrypted string after encryption.
     *
     * @param string $encrypt The encrypted string you want to compare against.
     * @param string $str The non-encrypted string to be verified.
     * @return bool Returns true if the non-encrypted string matches the encrypted string; otherwise, returns false.
     */
    public static function verifyEncryption(string $encrypt, string $str): bool
    {
        return hash_equals($encrypt, crypt($str, $encrypt));
    }
    /**
     * Get the "selected" attribute for a dropdown option based on a comparison.
     *
     * This public static method is used to determine whether a dropdown option should have the "selected" attribute
     * based on a comparison between two values. The method takes two parameters: `$value` and `$compared`. The `$value`
     * parameter represents the value of the dropdown option, and the `$compared` parameter represents the value to
     * compare against.
     *
     * If the `$value` is equal to the `$compared`, the method returns the string "selected", indicating that the option
     * should be marked as selected in the dropdown. If the values are not equal, the method returns an empty string.
     *
     * This method is commonly used in generating dropdowns with preselected options, where the selected option is based
     * on the comparison of the option value with some specific value.
     *
     * @param mixed $value The value of the dropdown option.
     * @param mixed $compared The value to compare against to determine if the option should be marked as selected.
     *
     * @return string Returns "selected" if the values are equal, or an empty string if the values are not equal.
     */
    public static function setSelectedAttribute($value, $compared): string
    {
        return $value == $compared ? "selected" : '';
    }

    /**
     * Get the properties and values of an enumerated class.
     *
     * This static method retrieves the properties and values of an enumerated class using reflection. The method takes two
     * parameters: `$class` (the name of the enumerated class) and `$format` (optional, determines the format of the returned array).
     *
     * The method uses reflection to extract the constants from the enumerated class. The `$format` parameter controls the format
     * of the returned array:
     *
     * - If `$format` is `true`, the method returns an array of constant values.
     * - If `$format` is `false`, the method returns an array of constant names.
     * - If `$format` is `null`, the method returns an associative array where keys are constant names and values are constant values.
     *
     * The method returns an array containing the properties and values of the enumerated class based on the specified `$format`.
     *
     * @param string $class The name of the enumerated class.
     * @param bool|null $format Optional. Determines the format of the returned array.
     *
     * @return array Returns an array containing the properties and values of the enumerated class based on the specified `$format`.
     * @throws ReflectionException
     */
    public static function getPropertyEnum(string $class, bool|null $format=true): array
    {

        $content = new ReflectionClass($class);
        $content = $content->getConstants();
        $values = [];
        foreach ($content as $property) {
            if ($format === true) {
                $values[] = $property->value;
            } elseif ($format === false) {
                $values[] = $property->name;
            } elseif($format == null) {
                $values[$property->name] = $property->value;
            }

        }
        return $values;
    }
}