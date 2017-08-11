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
        $uriArr = explode('/',$uri);
        if (empty($uri)) {
            include_once(ROOT.'/inc/controllers/IndexController.php');
            $indexController = new IndexController();
            $indexController->actionView();
        }elseif (array_shift($uriArr) == 'adminpanel') {
            include_once(ROOT.'/inc/controllers/AdminpanelController.php');
            $adminpanelController = new AdminpanelController($uriArr);
            $adminpanelController->actionView();
        }
    }

}