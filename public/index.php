<?php

if ( !defined("DS") ) {
    define("DS", "/");
}


require_once '..' . DS . 'app' . DS . 'config.php'; // Paht File Config.php

require_once APP_PATH . DS . "lib" . DS . "autoload.php";

//require_once APP_PATH . DS . "lib" . DS . "database/connection.php";

require_once APP_PATH . DS . "lib" . DS . 'mailer/vendor/autoload.php';

require_once APP_PATH . DS . "lib" . DS . 'Facebook/autoload.php';

$fb = new \Facebook\Facebook([
    'app_id' => '440912879835758', // Replace {app-id} with your app id
    'app_secret' => 'de55f17b4582045959ae0ea46e65b93e',
    'default_graph_version' => 'v2.2',
    ]);
$helper = $fb->getRedirectLoginHelper(); 
$permissions = ['email'];
//$GLOBALS['linkFacebook'] = $helper->getReRequestUrl('https://' . $_SERVER["HTTP_HOST"] . '/client/signInFacebook/', $permissions);
$GLOBALS['linkFacebook'] = $helper->getLoginUrl('https://' . $_SERVER["HTTP_HOST"] . '/client/signInFacebook/', $permissions);
$frontController = new \syriashop\lib\frontController();
$frontController->dispatch();
// حذف الاعلانات التي انتهت صلاحيتا
$ads = new \syriashop\modals\ItemsModals();
$item_media = $ads->sql("item_media", "items",
        "WHERE YEAR(item_end_date) = YEAR(NOW()) AND MONTH(item_end_date) = MONTH(NOW()) AND DAY(item_end_date) = DAY(NOW()) AND HOUR(NOW()) > HOUR(item_end_date) "
        . "OR ( YEAR(item_end_date) = YEAR(NOW()) AND MONTH(item_end_date) = MONTH(NOW()) AND DAY(item_end_date) < DAY(NOW()) AND HOUR(NOW()) > HOUR(item_end_date) )",
        null, "all");
// في حال وجود مرفقات لكي يتم حذفها
if ( !empty($item_media) ) {
    $dir = LOGO_PATH . DS . "items_media";
    foreach ( $item_media as $media ) {
        $media = explode(",", $media->item_media);
        foreach ( $media as $m ) {
            if ( file_exists($dir . DS . $m) ) {
                unlink($dir . DS . $m);
            }
        }
    }
}
$ads->delete(" WHERE YEAR(item_end_date) = YEAR(NOW()) AND MONTH(item_end_date) = MONTH(NOW()) AND DAY(item_end_date) = DAY(NOW()) AND HOUR(NOW()) > HOUR(item_end_date) "
        . "OR ( YEAR(item_end_date) = YEAR(NOW()) AND MONTH(item_end_date) = MONTH(NOW()) AND DAY(item_end_date) < DAY(NOW()) AND HOUR(NOW()) > HOUR(item_end_date) )");
