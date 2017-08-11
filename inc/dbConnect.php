<?php
/*require_once "controllers/db/Generic.php";

function databaseErrorHandler($message, $info)
{
    if (!error_reporting()) return;
    echo "SQL Error: $message<br><pre>"; //print_r($info); echo "</pre>";
}
//подключаемся к базе
$db = DbSimple_Generic::connect("mysql://".$dbUser.":".$dbPass."@".$dbHost."/".$dbName);
$db->setErrorHandler('databaseErrorHandler');

$db->query("SET NAMES 'UTF8'");*/

class DB {
    protected static $_instance;
    protected static$dbUser;
    protected static $dbPass;
    protected static $dbName;
    protected static $dbHost;

    private function __construct() {

    }

    public static function setDbParams($dbUser,$dbPass,$dbName,$dbHost) {
        self::$dbUser = $dbUser;
        self::$dbPass = $dbPass;
        self::$dbName = $dbName;
        self::$dbHost = $dbHost;
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            require_once "controllers/db/Generic.php";
            self::$_instance = DbSimple_Generic::connect("mysql://".self::$dbUser.":".self::$dbPass."@".self::$dbHost."/".self::$dbName);
            self::$_instance->setErrorHandler('databaseErrorHandler');
            self::$_instance->query("SET NAMES 'UTF8'");
        }

        return self::$_instance;
    }

    public function databaseErrorHandler($message, $info)
    {
        if (!error_reporting()) return;
        echo "SQL Error: $message<br><pre>"; //print_r($info); echo "</pre>";
    }

    private function __clone() {
    }

    private function __wakeup() {
    }
}

?>