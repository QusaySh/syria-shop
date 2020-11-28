<?php
namespace syriashop\lib;

/*
 * هو عبارة عن كلاس ليقوم باتحميل جميع الكلاسات التي لدي
 * 
 */
class AutoLoad {
    // lib\nameclass
    public static function autoload($className){
        $url = explode("\\", $className);
        array_shift($url);
        $url = implode("\\", $url);
        $path = APP_PATH . DIRECTORY_SEPARATOR . $url . ".php";
        if ( !file_exists($path) ) {
            return;
        }
        require $path;
    }
    
}

spl_autoload_register(__NAMESPACE__ . "\AutoLoad::autoload");