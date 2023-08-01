<?php

namespace APP;

use App\Core\Auth;
use App\Core\Cookie;
use App\Core\Engine;
use App\Core\Language;
use App\Core\Messages;
use App\Core\Registration;
use App\Core\Session;


! defined("DS") ? define("DS", DIRECTORY_SEPARATOR) : null;
error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once ".." . DS . "app" . DS . "config" . DS . "config.php";
require_once ".." . DS . "app" . DS . "config" . DS . "AppConfiguration.php";
require_once APP_PATH . DS . "core" . DS . "/Autoload.php";


Session::start();


if (! Cookie::has(LANGUAGE_NAME_COLUMNS_DB)) {
    Session::set(LANGUAGE_NAME_COLUMNS_DB,  APP_DEFAULT_LANGUAGE);
    Cookie::set(LANGUAGE_NAME_COLUMNS_DB,  APP_DEFAULT_LANGUAGE);
} else {
    Session::set(LANGUAGE_NAME_COLUMNS_DB,  Cookie::get(LANGUAGE_NAME_COLUMNS_DB));
    Cookie::set(LANGUAGE_NAME_COLUMNS_DB,  Cookie::get(LANGUAGE_NAME_COLUMNS_DB));
}



$auth       = Auth::getInstance();
$languages  = new  Language();
$messages   = Messages::getInstance();

$registry   = Registration::getInstance();

@$registry->language = $languages;
@$registry->messages  = $messages;


$app = new Engine($registry);
$app->request();