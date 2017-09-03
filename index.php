<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

session_start();

define('ROOT',dirname(__FILE__));
require_once (ROOT.'/config/dbconfig.php');
require_once (ROOT.'/inc/dbConnect.php');
require_once (ROOT.'/inc/Redirect.php');
require_once (ROOT.'/inc/Router.php');
require_once (ROOT.'/inc/controllers/AuthController.php');
require_once(ROOT . '/inc/models/ConfigModel.php');

DB::setDbParams($dbUser,$dbPass,$dbName,$dbHost);

$router = new Router();
$router->run();


