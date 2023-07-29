<?php

namespace App\Controllers;


use App\Core\Auth;
use App\Core\FilterInput;
use App\Core\Session;
use App\Core\View;
use App\Enums\MessagesType;
use App\Models\Model;
use ErrorException;
use JetBrains\PhpStorm\NoReturn;

class AuthController extends AbstractController
{

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
        $pattern = "/^[^\s]*@stu\.ttu\.edu\.jo$/";
        return preg_match($pattern, $email) === 1;
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
     * @param string $nameUser The name of the user for whom the password verification is being performed.
     *
     * @return bool Returns true if the passwords match, otherwise returns false.
     */
    private function verifyPassword(string $sortedPassword, string $password, string $nameUser): bool
    {
        if (self::verifyEncryption($sortedPassword, $password)) {
            $this->setMessage("welcome_back", $nameUser, MessagesType::Success->name);
            return true;
        } else {
            $this->setMessage("not_valid_pass", '', MessagesType::Danger->name);
            return false;
        }
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
                $model = "App\Models\\". $table."Model";

                $sql = "SELECT * FROM {$table} WHERE {$uniqueColumn} = '{$email}'";

                $user = new $model();
                $user = $user->row($sql);

                $passwordColumn = $columns["password"];

                $valid = $this->verifyPassword($user->$passwordColumn, $password, $user->Name);

                if ($valid) {
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
            $this->setMessage("email_tld", '', MessagesType::Danger->name);
            return false;
        }
        return false;
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
                Session::set("user", $user);
                echo "<pre>";
                    var_dump(Auth::privilege());
                echo "</pre>";
                exit();
            }
        }
        
        View::view("auth.login", $this, [
        ]);
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
        Session::kill();
        $this->redirect("/auth/login");
    }
}