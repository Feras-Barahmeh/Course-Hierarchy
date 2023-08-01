<?php

enum TypeDriver : int
{
    case pdo = 1;
    case mysql = 2;
}

define("APP_PATH", realpath(dirname(__FILE__, 2)));
const VIEWS_PATH = APP_PATH . DS . "views" . DS;

const TEMPLATE_PATH = APP_PATH . DS . 'templates' . DS;

const CSS = DS . "css" . DS;
const BOOTSTRAP_CSS = DS . "css" . DS . "bootstrap" . DS;

const JS  = DS . "js" . DS;
const BOOTSTRAP_JS = DS . "js" . DS . "bootstrap" . DS;
const IMG  = DS . "images" . DS;


// Cookie configuration
const COOKIE_PATH= '/';


const LANGUAGES_PATH = APP_PATH . DS . "languages" . DS;

// Salts
const MAIN_SALT = '$2a$07$yeNCSNwRpYopOhv0TrrReP$';


// Database Credentials
defined('DATABASE_HOST_NAME')           ?
    null : define ('DATABASE_HOST_NAME', 'localhost');
defined('DATABASE_USER_NAME')           ?
    null : define ('DATABASE_USER_NAME', 'root');
defined('DATABASE_PASSWORD')            ?
    null : define ('DATABASE_PASSWORD', '');
defined('DATABASE_DB_NAME')              ?
    null : define ('DATABASE_DB_NAME', 'PreCatalog');
defined('DATABASE_PORT_NUMBER')     ?
    null : define ('DATABASE_PORT_NUMBER', 3306);
defined('DATABASE_CONN_DRIVER')       ?
    null : define ('DATABASE_CONN_DRIVER',  TypeDriver::pdo);