<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Cookie;
use App\Core\Session;
use App\Enums\Language;
use App\Models\Model;
use JetBrains\PhpStorm\NoReturn;

class SettingsController extends AbstractController
{
    public function index(): void
    {

    }

    /**
     * Change the user's language preference in the database and update the Auth user object.
     *
     * This method is responsible for updating the user's language preference in the database
     * and updating the Auth user object accordingly. It uses the provided `$newLanguage` parameter
     * to set the new language for the user.
     *
     * @param string|int $newLanguage The new language to be set for the user.
     * @return void
     */
    private function changeUserLanguage(string|int $newLanguage): void
    {
        $class = get_class(Auth::user());
        $class = new $class();
        $PK = $class->getPK();
        $table = $class->getTableName();

        Model::update($table, [LANGUAGE_NAME_COLUMNS_DB], [$newLanguage], "$PK = " . Auth::user()->{$PK});
        Model::update($table, LANGUAGE_NAME_COLUMNS_DB, $newLanguage, "$PK = " . Auth::user()->{$PK});
        Auth::user()->{LANGUAGE_NAME_COLUMNS_DB} = $newLanguage;

    }
    /**
     * Change the user's language and redirect to the homepage.
     *
     * This method allows the user to switch between English and Arabic languages and sets
     * the appropriate language in the session and cookies. It then calls the `changeUserLanguage`
     * method to update the user's language preference in the backend.
     *
     * @return void
     */
    #[NoReturn] public function language(): void
    {
        
        if (Auth::user()->language == Language::English->value) {
            Session::set(LANGUAGE_NAME_COLUMNS_DB, Language::Arabic->value);
            Cookie::set(LANGUAGE_NAME_COLUMNS_DB, Language::Arabic->value);
            $this->changeUserLanguage(Language::Arabic->value);

        } else {
            Session::set(LANGUAGE_NAME_COLUMNS_DB, Language::English->value);
            Cookie::set(LANGUAGE_NAME_COLUMNS_DB, Language::English->value);
            $this->changeUserLanguage(Language::English->value);
        }


        $this->redirect("/");
    }
}