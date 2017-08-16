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
        if ($uriArr[0] == 'adminpanel') {
            array_shift($uriArr);
            include_once(ROOT.'/inc/controllers/AdminpanelController.php');
            $adminpanelController = new AdminpanelController($uriArr);
            $adminpanelController->actionView();
        }else {
            include_once(ROOT.'/inc/controllers/IndexController.php');
            $indexController = new IndexController($uriArr);
            $indexController->actionView();
        }
    }

}