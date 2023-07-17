<?php
/**
 * Name File Css and Js Must be same controller name
 */

$cssLang = \App\Core\Session::get("lang")== "ar" ? "ar" . DS : "en" . DS;

$t = explode('/', $_SERVER["REQUEST_URI"]);
$shiftedArray = array_shift($t);

$CSS = [
    "main"          => CSS . $cssLang . "main"     . ".css",
    "shortcut"      => CSS . "shortcut" . ".css",
];

$CSS[$t[0]] = CSS . $cssLang . $t[0] . ".css";

$JS = [
    "main"          => JS . "main"      . ".js",
    "shortcut"      => JS . "shortcut"  . ".js",
    "fontawesome"   =>  "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.js"
];

$JS[$t[0]] = JS . $t[0] . ".js";

return [
    NAME_TEMPLATE_HEADER_RESOURCES => [
        "css" => $CSS,
        "js" => [
            "fontawesome"   =>  "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.js"
        ],
    ],

    NAME_TEMPLATE_FOOTER_RESOURCES => [
        "js" => $JS,
    ],
];