<?php
class IndexController {

    public function __construct() {
    }

    public function actionView() {
        require_once (ROOT.'/inc/views/IndexView.php');
        $indexView = new IndexView();
        echo $indexView->actionView();
    }

}