<?php

$localhost = "localhost";
$dbname = "syriaShop";
$dbuser = "root";
$dbpassword = "";
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8",
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);

try{
    global $conn;
    $conn = new PDO("mysql://host=$localhost;dbname=$dbname", $dbuser, $dbpassword, $option);
} catch (PDOException $e) {
    echo $e->getMessage();
}