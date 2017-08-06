<?php
class Router {

    public function __construct() {


    }

    private function getURI() {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run() {
        $uri = $this->getURI();
        if (empty($uri)) {
            include_once(ROOT.'/inc/controllers/IndexController.php');
            $indexController = new IndexController();
            $indexController->actionView();
        }
    }

}