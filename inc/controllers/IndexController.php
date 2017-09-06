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
        $orgModelObj = new OrgModel();
        $indexView = new IndexView();
        if ($this->uriArr[0] == 'organizations') {
            if ($this->uriArr[1] == 'json') {
                echo $orgsJson = OrgModel::getAllOrgsForJson();
                die();
            }
        }elseif ($this->uriArr[0] == 'next-page') {
            $page = $_SESSION['pageOrg'];
            $prop = array();
            if (!empty($_SESSION['with-mobile'])) $prop['mobile'] = 1;
            $page++;
            $_SESSION['pageOrg'] = $page;
            $orgsArr = $orgModelObj->getOrgs($page,7,$prop);
            echo OrgView::orgsIndexView($orgsArr);
            die();
        }elseif ($this->uriArr[0] == 'with-mobile') {
            $_SESSION['with-mobile'] = 1;
            $orgsArr = $orgModelObj->getOrgs(1,7,array('mobile'=>1));
            echo OrgView::orgsIndexView($orgsArr);
            die();
        }elseif ($this->uriArr[0] == 'without-mobile') {
            $_SESSION['with-mobile'] = 0;
            $_SESSION['pageOrg'] = 1;
            $orgsArr = $orgModelObj->getOrgs(1,7);
            echo OrgView::orgsIndexView($orgsArr);
            die();
        }

        $_SESSION['pageOrg'] = 1;
        $_SESSION['with-mobile'] = 0;
        $orgsArr = $orgModelObj->getOrgs(1,7);
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