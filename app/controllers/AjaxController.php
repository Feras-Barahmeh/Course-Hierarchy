<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Cookie;
use App\Enums\Language;
use App\Enums\Privilege;

class AjaxController extends AbstractController
{
    public static int $authentication = Privilege::Admin->value;

    /**
     * getAppLanguage() Method
     *
     * This method is responsible for determining the user's preferred language in the application.
     * It considers both user authentication status and language settings stored in cookies.
     * Based on these factors, the method returns a JSON-encoded response containing the name of the preferred language.
     *
     * @return void
     *
     * @link http://precatalog.local/ajax/getAppLanguage
     */
    public function getAppLanguage(): void
    {
        $langName = null;

        if (Auth::isLogged()) {
            if (Auth::user()->{LANGUAGE_NAME_COLUMNS_DB} === Language::Arabic->value) {
                $langName = Language::Arabic->name;
            } else {
                $langName = Language::English->name;
            }
        } elseif(Cookie::get("language")) {
            if (Cookie::get("language") === Language::Arabic->value) {
                $langName = Language::Arabic->name;
            } else {
                $langName = Language::English->name;
            }
        }
        if (self::$authentication === Auth::privilege()) {
            echo json_encode([
                "language" => $langName,
            ]);
        }

    }
}