<?php
require_once(ROOT.'/inc/Templates.php');

class AdminpanelView extends Templates {

    public function __construct() {
    }

    public function loginView() {
        $loginFormView = new Templates(ROOT.'/templates/adminpanel/loginform.html');
        return $loginFormView->output();
    }
    public function adminView($pageAction,$userparams) {
        //главная страница админпанели
        parent::__construct(ROOT.'/templates/adminpanel/index.html');
        $this->replace('username',$userparams['login']);
        $pageActionName = $pageAction.'View';
        $this->replace('content',$this->$pageActionName());
        return $this->output();
    }

    public function indexView() {
        $indexView = new Templates(ROOT.'/templates/adminpanel/main.html');
        return $indexView->output();
    }

    public function indexOrgView() {
        $indexOrgView = new Templates(ROOT.'/templates/adminpanel/indexorg.html');
        return $indexOrgView->output();
    }

    public function importView() {
        $importView = new Templates(ROOT.'/templates/adminpanel/orgimport.html');
        return $importView->output();
    }

}