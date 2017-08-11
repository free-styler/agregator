<?php
require_once(ROOT.'/inc/Templates.php');

class AdminpanelView extends Templates {

    public function __construct() {
    }

    public function loginView() {
        parent::__construct(ROOT.'/templates/adminpanel/loginform.html');
        return $this->output();
    }
    public function adminView($userparams) {
        parent::__construct(ROOT.'/templates/adminpanel/index.html');
        $this->replace('username',$userparams['login']);
        return $this->output();
    }

}