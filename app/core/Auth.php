<?php

namespace App\Core;

use App\Enums\Privilege;

class Auth
{
    /**
     * unique instance for this class
     * @var
     */
    private static $_instance;

    public static string $privilegeNameColumn = "Privilege";
    /**
     * tables contain privilege and what is name unique column (the key is name table, value is privilege name unique column, password name password column in db)
     * name table must be the same name mode example if table name AdminModel the key in array Admin
     * @var array|string[]
     */
    public static array $tables = [
        "Guide"         => ["unique" => "Email", "password" => "Password"],
        "Instructors"   => ["unique" => "Email", "password" => "Password"],
        "Students"      => ["unique" => "Email", "password" => "Password"],
        "Admin"         => ["unique" => "Email", "password" => "Password"],
    ];
    /**
     * construct
     */
    private function __construct() {}

    /**
     * @return string
     */
    public static function getPrivilegeNameColumn(): string
    {
        return self::$privilegeNameColumn;
    }

    /**
     * @param string $privilegeNameColumn new name
     */
    public static function setPrivilegeNameColumn(string $privilegeNameColumn): void
    {
        self::$privilegeNameColumn = $privilegeNameColumn;
    }

    private function __clone() {}

    /**
     * return instance in this class (unique) object
     * @return Auth
     */
    public static function getInstance(): Auth
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * check if user in session or not
     * @return bool
     */
    public static function isLogged(): bool
    {
        return Session::get("user") !== null;
    }

    /**
     * get user object
     * @return object|false return object user if exist in session or not
     */
    public static function user(): object|false
    {
        if (Session::get("user") != null) {
            return Session::get("user");
        }
        return false;
    }

    /**
     * get value column from user object
     * @return mixed value column in user object
     */
    public static function privilege(): mixed
    {
        if (self::user() !== false) {
            return self::user()->{static::getPrivilegeNameColumn()};
        }
        return false;
    }

    public static function access($privilege): bool
    {
        $access[Privilege::Admin->value] = [Privilege::Admin->value];
        $access[Privilege::Instructor->value] = [Privilege::Admin->value, Privilege::Instructor->value];
        $access[Privilege::Guide->value] = [Privilege::Admin->value, Privilege::Guide->value];
        $access[Privilege::Student->value] = [Privilege::Admin->value, Privilege::Student->value];

        $role = self::privilege();

        if (in_array($role, $access[$privilege])) {
            return true;
        }
        return false;
    }
}