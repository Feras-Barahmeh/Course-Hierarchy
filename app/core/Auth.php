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
        "Guides"         => ["unique" => "Email", "password" => "Password"],
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
    /**
     * Get the model class name associated with the authenticated user.
     *
     * This static method retrieves and returns the class name of the model associated with the
     * currently authenticated user. The method utilizes the `Auth` class to fetch the authenticated
     * user instance, and then uses the `get_class()` function to get the name of the corresponding
     * model class.
     *
     * @return string Returns the class name of the model associated with the authenticated user.
     */
    public static function getModelUser(): string
    {
        return get_class(Auth::user());
    }
    /**
     * Get the primary key value of the authenticated user's model instance.
     *
     * This static method retrieves and returns the primary key value of the model instance
     * associated with the currently authenticated user. It first obtains the class name of the
     * model using the `Auth::user()` method, then creates a new instance of the model class,
     * and finally calls the `getPK()` method on the created instance to get the primary key value.
     *
     * @return string Returns the primary key value of the authenticated user's model instance.
     */
    public static function getPKUser(): string
    {
        $class = get_class(Auth::user());
        $class = new $class();
        return $class->getPK();
    }
    /**
     * Get the database table name associated with the authenticated user's model.
     *
     * This static method retrieves and returns the name of the database table associated with the
     * model instance of the currently authenticated user. It first obtains the class name of the model
     * using the `Auth::user()` method, then creates a new instance of the model class, and finally calls
     * the `getTableName()` method on the created instance to get the table name.
     *
     * @return string Returns the name of the database table associated with the authenticated user's model.
     */
    public static function getTableUser(): string
    {
        $class = get_class(Auth::user());
        $class = new $class();
        return $class->getTableName();
    }
    /**
     * Get the name of the language for the currently authenticated user.
     *
     * This static method retrieves and returns the name of the language set for the currently
     * authenticated user. It checks the language value stored in the user's database record
     * (assuming the existence of a 'language' field) and returns the corresponding language name.
     * The method uses the Language enum to access the language values and names.
     *
     * @return string Returns the name of the language for the currently authenticated user.
     *                The name can be either "English" or "Arabic" based on the user's language setting.
     */
    public static function getNameLanguage(): string
    {
        if (Auth::user()->language == Language::English->value) {
            return Language::English->name;
        } else {
            return Language::Arabic->name;
        }
    }
    /**
     * Update the currently authenticated user in the session.
     *
     * This static method is used to update the currently authenticated user's data in the session.
     * It takes the provided `$newUser` object representing the updated user data and sets it in the
     * session under the key "user". The method is typically used to keep the user's session data
     * up-to-date after making changes to the user's profile or account information.
     *
     * @param object $newUser The updated user data represented as an object.
     *
     * @return void
     */
    public static function updateUser(object $newUser): void
    {
        Session::set("user", $newUser);
    }
}