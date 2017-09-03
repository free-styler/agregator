<?php

require_once (ROOT.'/inc/views/IndexView.php');
require_once (ROOT.'/inc/views/OrgView.php');
require_once (ROOT .'/inc/models/OrgModel.php');

class IndexController {

    private $uriArr = array();

    public function __construct($uriArr) {
        $this->uriArr = $uriArr;
    }

    public function actionView() {
        $indexView = new IndexView();
        if ($this->uriArr[0] == 'organizations') {
            if ($this->uriArr[1] == 'json') {
                echo $orgsJson = OrgModel::getAllOrgsForJson();
                die();
            }
        }
        $orgModelObj = new OrgModel();
        $orgsArr = $orgModelObj->getOrgs(1,20);
        echo $indexView->actionView($orgsArr);
    }

    public function orgView() {
        if ($this->uriArr[0] == 'org') {
            if (!empty($this->uriArr[1]) && intval($this->uriArr[1])) {
                if (!empty($this->uriArr[2]) && ($this->uriArr[2] == 'setrating')) {
                    echo OrgModel::setOrgRating($this->uriArr[1],$_POST['star'],$_SERVER["REMOTE_ADDR"]);
                    die();
                }
                $orgArr = OrgModel::getOrg($this->uriArr[1]);
                echo OrgView::organizationView($orgArr);
            }else  Redirect::go('/', '');
        }elseif ($this->uriArr[0] == 'search') {
            if (!empty($_POST)) {
                $orgsArr = OrgModel::getOrgByName($_POST['search']);
                $indexView = new IndexView();
                echo $indexView->actionView($orgsArr);
            }
        }
    }

}