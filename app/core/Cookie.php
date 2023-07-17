<?php

namespace App\Core;

class Cookie
{
    /**
     * Cookie constructor
     */
    private function __construct(){}

    /**
     * set cookie
     * @param string $key cookie key
     * @param string $value key value
     * @param mixed|null $expired expired time default 1 year
     * @param string|null $cookiePath
     * @return string
     */
    public static function set(string $key, string $value, mixed $expired=null, string $cookiePath=null): string
    {
        $expired = ! $expired ?  time() + (365 * 24 * 60 *60) : $expired;
        $cookiePath = ! $cookiePath ? COOKIE_PATH : $cookiePath;
        setcookie($key, $value, $expired, $cookiePath, '', false, true);
        return $value;
    }

    /**
     * check if cookie has key
     * @param string $key name key
     * @return bool rerun true if it has this key false anther wise
     */
    public static function has(string $key): bool
    {
        return isset($_COOKIE[$key]);
    }
    /**
     * get cookie by key
     * @param string $key name key
     * @return  mixed return cookie if set
     */
    public static function get(string $key): mixed
    {
        return self::has($key) ? $_COOKIE[$key] : null;
    }

    /**
     * remove key from
     * @param string $key
     * @return void
     */
    public static function remove(string $key): void
    {
        unset($_COOKIE[$key]);
        setcookie($key, '', '-1',  '/');
    }

    /**
     * return all cookies
     * @return array|bool return array if not empty cookie false is empty
     */
    public static function all(): array| bool
    {
        return ! empty($_COOKIE) ? $_COOKIE : false;
    }

    /**
     * kill cookie
     * @return void
     */
    public static function kill(): void
    {
        foreach (self::all() as $key => $value) {
            self::remove($key);
        }
    }

}