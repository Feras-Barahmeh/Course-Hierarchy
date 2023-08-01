<?php

namespace App\Core;

use App\Enums\Privilege;
use App\Enums\Language;
class Auth
{
    /**
     * unique instance for this class
     * @var
     */
    private static $_instance;

    public static array $access = [];

    /**
     * Set up the access privilege data for different user roles.
     *
     * This method is used to set up the access privilege data for different user roles in the application.
     * It initializes the static `$access` array, associating each user role with an array of privileges that
     * the role possesses. The privileges are defined by the `Privilege` class constants, where each constant
     * represents a specific privilege value associated with a role.
     *
     * @return void
     */
    public static function setAccess(): void
    {
        self::$access[Privilege::Admin->value] = [Privilege::Admin->value];
        self::$access[Privilege::Instructor->value] = [Privilege::Admin->value, Privilege::Instructor->value];
        self::$access[Privilege::Guide->value] = [Privilege::Admin->value, Privilege::Guide->value];
        self::$access[Privilege::Student->value] = [Privilege::Admin->value, Privilege::Student->value];
    }

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
    /**
     * Check if a user with a specific privilege has access to perform certain actions.
     *
     * @param int $privilege The privilege level of the user.
     * @return bool Returns true if access is granted, false otherwise.
     */
    public static function access(int $privilege): bool
    {

        self::setAccess();

        $role = self::privilege();

        if (in_array($role, self::$access[$privilege])) {
            return true;
        }
        return false;
    }

    /**
     * Check if a user role has the necessary access privilege for a controller action.
     *
     * This method is used to check if a user role has the necessary access privilege to perform a specific
     * action (controller privilege) on a controller. It relies on the `setAccess()` method to set up the access
     * privilege data, which likely contains an array of roles mapped to their respective privileges.
     *
     * @param int|string $role The user role for which access privilege is to be checked.
     * @param int|string $controllerPrivilege The privilege associated with the controller action to be checked.
     *
     * @return bool Returns true if the specified user role has the required access privilege, false otherwise.
     */
    public static function performAuthenticatedAccessCheck(int|string $role, int|string $controllerPrivilege): bool
    {
        self::setAccess();
        return in_array($controllerPrivilege, self::$access[$role]);
    }

    public static function getModelUser(): string
    {
        return get_class(Auth::user());
    }
    public static function getPKUser(): string
    {
        $class = get_class(Auth::user());
        $class = new $class();
        return $class->getPK();
    }

    public static function getTableUser()
    {
        $class = get_class(Auth::user());
        $class = new $class();
        return $class->getTableName();
    }

    public static function getNameLanguage(): string
    {
        if (Auth::user()->language == Language::English->value) {
            return Language::English->name;
        } else {
            return Language::Arabic->name;
        }
    }

    public static function updateUser($newUser)
    {
        Session::set("user", $newUser);
    }
}