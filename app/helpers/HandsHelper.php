<?php

namespace App\Helper;
use JetBrains\PhpStorm\NoReturn;

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
    public function convertCamelToSpace(string $string): string|false
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

}