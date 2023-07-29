<?php
namespace App\Core;

class Session
{
    /**
     * Cookie constructor
     */
    private function __construct(){}
    /**
     * start session
     * @return bool
     */
    public static function start(): bool
    {
        if (! session_id()) {
            ini_set("session.use_cookies", 1);
            return session_start();
        }
        return false;
    }
    /**
     * set cookie
     * @param string $key cookie key
     * @param mixed $value key value
     * @return void
     */
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }
    /**
     * check if session has key
     * @param string $key name key
     * @return bool rerun true if it has this key false anther wise
     */
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }
    /**
     * get session by key
     * @param string $key name key
     * @return  mixed return session if set
     */
    public static function get(string $key): mixed
    {
        return self::has($key) ? $_SESSION[$key] : null;
    }
    /**
     * remove key from
     * @param string $key
     * @return void
     */
    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
        setcookie($key, '', '-1',  '/');
    }

    /**
     * return all session
     * @return array|bool return array if not empty session false is empty
     */
    public static function all(): array| bool
    {
        return ! empty($_SESSION) ? $_SESSION : false;
    }
    /**
     * kill session
     * @return void
     */
    public static function kill(): void
    {
        session_unset();    // delete variables in session
        session_destroy(); // delete session don't approaches in session variables
    }

    /**
     * get key session value then remove it from session
     * @param $key
     * @return mixed|null return key value
     */
    public static function flash($key): mixed
    {
        $value = null;
        if (isset($_SESSION[$key] )) {
            $value = $_SESSION[$key];
            unset($_SESSION[$key]);
        }
        return $value;
    }

}