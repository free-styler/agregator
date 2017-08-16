<?php
class IndexController {

    private $uriArr = array();

    public function __construct($uriArr) {
        $this->uriArr = $uriArr;
    }

    public function actionView() {
        require_once (ROOT.'/inc/views/IndexView.php');
        $indexView = new IndexView();
        if ($this->uriArr[0] == 'organizations') {
            require_once(ROOT . '/inc/models/OrgModel.php');
            if ($this->uriArr[1] == 'json') {
                echo $orgsJson = OrgModel::getAllOrgsForJson();
                die();
            }
        }

        echo $indexView->actionView();
    }

}