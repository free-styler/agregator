<?php
require_once "controllers/db/Generic.php";

function databaseErrorHandler($message, $info)
{
    if (!error_reporting()) return;
    echo "SQL Error: $message<br><pre>"; //print_r($info); echo "</pre>";
}
//подключаемся к базе
$db = DbSimple_Generic::connect("mysql://".$dbUser.":".$dbPass."@".$dbHost."/".$dbName);
$db->setErrorHandler('databaseErrorHandler');

$db->query("SET NAMES 'UTF8'");

?>