<?php

namespace APP;

use App\Core\Engine;
use App\Core\Language;
use App\Core\Messages;
use App\Core\Registration;
use App\Core\Session;
use App\Core\Template;


! defined("DS") ? define("DS", DIRECTORY_SEPARATOR) : null;
error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once ".." . DS . "app" . DS . "config" . DS . "config.php";
require_once APP_PATH . DS . "core" . DS . "/Autoload.php";


Session::start();

if (! Session::has("lang")) {
    Session::set("lang",  APP_DEFAULT_LANGUAGE);
}

$nameFilesFrontend = require_once ".." . DS . "app" . DS . "config" . DS . "FilesTemplate.php";

$template       = new Template($nameFilesFrontend);
$languages      = new  Language();
$messages = Messages::getInstance();


$registry       = Registration::getInstance();

@$registry->language = $languages;
@$registry->messages  = $messages;



$app = new Engine($template, $registry);
$app->request();