<?php
namespace syriashop\lib;
use PDO;



trait Database {
    private static $connetion = null;
    private static $localhost = "localhost";
    private static $dbname = "syriaShop";
    private static $dbuser = "root";
    private static $dbpassword = "";
    private static $option = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );
    public static function setConn(){
        try{
            $conn = new PDO("mysql://host=". self::$localhost .";dbname=" . self::$dbname,
            self::$dbuser, self::$dbpassword, self::$option);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $conn;
    }
    public static function closeConn(){
        $conn = null;
    }
}
