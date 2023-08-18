<?php

namespace App\Controllers;


use App\Core\Auth;
use App\Core\Cookie;
use App\Core\FilterInput;
use App\Core\Session;
use App\Core\View;
use App\Enums\MessagesType;
use App\Enums\Privilege;
use App\Models\Model;
use ErrorException;
use JetBrains\PhpStorm\NoReturn;

class AuthController extends AbstractController
{
    /**
     * This method to redirect login page
     * @return void
     */
    #[NoReturn] public function index(): void
    {
        $this->redirect("/auth/login");
    }
    /**
     * Check Top-Level Domain (TLD) of an email address.
     *
     * This method checks if the email address provided contains a valid Top-Level Domain (TLD).
     * It verifies whether the email matches a specific pattern for the domain "stu.ttu.edu.jo".
     * If the email has a valid TLD, the method returns true; otherwise, it returns false.
     *
     * @param string $email The email address to be checked for a valid TLD.
     *
     * @return bool Returns true if the email has a valid TLD ("stu.ttu.edu.jo"), false otherwise.
     */
    private function checkTDL(string $email): bool
    {
        foreach (TLD_PARTS as $index => $change) {

            $pattern = "/^[^\s]*@{$change}\.ttu\.edu\.jo$/";
            if (preg_match($pattern, $email) == 1) {
                return true;
            }
        }
        return false;
    }

    /**
     * Verifies a user's password against a sorted password.
     *
     * This method compares the provided sorted password with the user's actual password.
     * If the passwords match, a success message is added to the messages container.
     * If the passwords do not match, an error message is added to the messages container.
     *
     * @param string $sortedPassword The sorted password stored in the database.
     * @param string $password The user's password to be verified.
     * @return bool Returns true if the passwords match, otherwise returns false.
     */
    private function verifyPassword(string $sortedPassword, string $password): bool
    {
        if (self::verifyEncryption($sortedPassword, $password)) {
            return true;
        } else {
            $this->setMessage("not_valid_pass", '', MessagesType::Danger->name);
            return false;
        }
    }

    private function searchColumnContainName($columns)
    {
        $pattern = '/name/i';
        foreach ($columns as $column) {
            if (preg_match($pattern, $column)) {
                return $column;
            }
        }
        return false;
    }
    /**
     * Authenticate and retrieve a user by email and password from the authentication tables.
     *
     * This method attempts to authenticate a user by searching for the provided email
     * in the authentication tables defined in the `Auth::$tables` array. If a user with
     * the given email is found, it verifies the provided password against the stored
     * password using the `verifyPassword()` method. If the authentication is successful,
     * the method returns the user object; otherwise, it returns false.
     *
     * @param string $email The email of the user to authenticate.
     * @param string $password The password to verify for the user.
     *
     * @return mixed Returns the authenticated user object on success or false if authentication fails.
     *               The user object contains information about the user, and its structure depends
     *               on the specific table and model being used.
     *               Note: If the email is not found, an error message is set using the `setMessage()`
     *               method, and false is returned.
     */
    private function authenticateUser(string $email, string $password): mixed
    {
        foreach (Auth::$tables as $table => $columns) {
            $uniqueColumn = $columns["unique"];
            $exits = Model::equal($table, $uniqueColumn, $email);

            if ($exits) {
                $tableModel = $table;
                if ($table[strlen($table) - 1] === 's') {
                    $tableModel = substr($table, 0, -1) ;
                }
                $model = "App\Models\\". $tableModel."Model";

                $sql = "SELECT * FROM {$table} WHERE {$uniqueColumn} = '{$email}'";

                $user = new $model();
                $user = $user->row($sql);

                $passwordColumn = $columns["password"];

                $nameColumn = $this->searchColumnContainName($user::getTableSchema());

                $valid = $this->verifyPassword($user->$passwordColumn, $password);

                if ($valid) {
                    $this->setMessage("welcome_back", $user->{$nameColumn}, MessagesType::Success->name);
                    return  $user;
                }
            }
        }

        $this->setMessage("email_not_exists",$email, MessagesType::Danger->name);
        return  false;
    }

    /**
     * Retrieve and authenticate a user by email and password.
     *
     * This method attempts to retrieve a user with the provided email and authenticate them
     * by checking the provided password. It performs additional checks on the email, such as
     * verifying the top-level domain (TLD) using the `checkTDL()` method and filtering the email
     * input with the `FilterInput::str()` method. If the user is found and authentication is
     * successful, the method returns the authenticated user object; otherwise, it returns false.
     *
     * @param string $email The email of the user to retrieve and authenticate.
     * @param string $password The password to verify for the user.
     *
     * @return object|false Returns the authenticated user object on success or false if retrieval
     *                      or authentication fails. The user object contains information about the
     *                      user, and its structure depends on the specific table and model being used.
     *                      Note: If the email is invalid due to an invalid TLD, an error message is set
     *                      using the `setMessage()` method, and false is returned.
     */
    private function retrieveAndAuthenticateUser(string $email, string $password): object|false
    {

        if ($this->checkTDL($email)) {
            FilterInput::str($email);
            $user = $this->authenticateUser($email, $password);
            if ($user) {
                return $user;
            }

        } else {
            $this->setMessage("email_tld", '', MessagesType::Danger);
            return false;
        }
        return false;
    }
    /**
     * Redirects the user based on their privilege level.
     *
     * This method is intended to be used internally within the class and should not be accessed
     * directly from outside the class.
     *
     * @param int $privilege The privilege level of the user.
     * @return void
     */
    private function redirectBasedOnPrivilege(int $privilege): void
    {
        if ($privilege === Privilege::Admin->value) {
            $this->redirect('/');
        }
        if ($privilege === Privilege::Guide->value) {
            $this->redirect("/guidesuser");
        }
    }
    /**
     * Perform user login process.
     *
     * This method handles the user login process. It loads the language file for the login page,
     * checks if the login form has been submitted, retrieves and authenticates the user using the
     * provided email and password with the `retrieveAndAuthenticateUser()` method. If the authentication
     * is successful, it sets the user object in the session using the `Session::set()` method.
     *
     * @return void This method does not return any value.
     * @throws ErrorException
     */
    public function login(): void
    {
        $this->language->load("auth.login");

        if (isset($_POST["login"])) {
            $email    = $_POST["Email"];
            $password = $_POST["Password"];

            $user = $this->retrieveAndAuthenticateUser($email, $password);
           
            if ($user) {
                Cookie::set(LANGUAGE_NAME_COLUMNS_DB, $user->{LANGUAGE_NAME_COLUMNS_DB});
                Session::set(LANGUAGE_NAME_COLUMNS_DB, $user->{LANGUAGE_NAME_COLUMNS_DB});
                Session::set("user", $user);
                $this->redirectBasedOnPrivilege($user->Privilege);
            }
        }

        View::view("auth.login", $this);
    }
    /**
     * Perform user logout action.
     *
     * This method handles the user logout action. It clears all data stored in the session
     * using the `Session::kill()` method, effectively logging out the current user. After
     * clearing the session data, the method redirects the user to the login page using the
     * `redirect()` method.
     *
     * @return void This method does not return any value.
     */
    #[NoReturn] public function logout(): void
    {
        Cookie::set(LANGUAGE_NAME_COLUMNS_DB, Auth::user()->{LANGUAGE_NAME_COLUMNS_DB});
        Session::kill();
        $this->redirect("/auth/login");
    }

    /**
     * Handle access denied scenarios and display an "access denied" view.
     *
     * This method is used to handle access denied scenarios in the application, where a user does not have
     * the necessary permission to access a specific resource or perform a certain action. The method loads
     * the language file related to the "access denied" message and sets up the necessary data to be displayed
     * in the view. It then renders the "access denied" view to inform the user about the lack of permission.
     *
     * @throws ErrorException If there is an error while loading the language file or rendering the view.
     * @return void
     */
    public function accessDenied(): void
    {
        $this->language->load("auth.denied");
        View::view("auth.denied", $this);
    }
}