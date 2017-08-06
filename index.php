<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

define('ROOT',dirname(__FILE__));
require_once (ROOT.'/config.php');
require_once (ROOT.'/inc/dbConnect.php');

$users = $db->query('SELECT * FROM users');
print_r($users);


