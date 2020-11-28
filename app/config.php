<?php

if ( !defined("DS") ) {
    define("DS", DIRECTORY_SEPARATOR);
}

if ( isset($_COOKIE["lang"]) ) {
    $GLOBALS["lang"] = $_COOKIE["lang"];
} else {
    setcookie("lang", "ar", strtotime("+30day"), "/", $_SERVER["HTTP_HOST"]);
    $GLOBALS["lang"] = "ar";
}
if ( isset($_COOKIE["country"]) ) {
    $GLOBALS["country"] = $_COOKIE["country"];
} else {
    setcookie("country", 10, strtotime("+30day"), "/", $_SERVER["HTTP_HOST"]);
    $GLOBALS["country"] = 10;
}
if ( isset($_COOKIE["city"]) ) {
    $GLOBALS["city"] = $_COOKIE["city"];
} else {
    setcookie("city", "all", strtotime("+30day"), "/", $_SERVER["HTTP_HOST"]);
    $GLOBALS["city"] = "all";
}

// APP PATH
define("APP_PATH", dirname(__FILE__));
// VIEWS PATH
define("VIEWS_PATH", APP_PATH . DS . "views");
// TEAMPLATE PATH
define("TEMPLATE_PATH", APP_PATH . DS . "template");

// Media PATH
//define("MEDIA_PATH", APP_PATH . DS . "items_media");
define("LOGO_PATH", dirname(dirname(__FILE__)) . DS . "public");

define("COUNT_ADS", 20); // عدد الاعلانات المراد ظهورها
define("COUNT_TABLE", 10); // عدد السجلات المراد ظهورها

define("ALLOW_IMG", ['jpg', 'png', 'gif', 'jpeg']);
define("ALLOW_VEDIO", ['mp4']);