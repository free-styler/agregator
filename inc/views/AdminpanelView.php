<?php
require_once(ROOT.'/inc/Templates.php');

class AdminpanelView extends Templates {

    public $uriArr;
    private $userParams;

    public function __construct($uriArr) {
        $this->uriArr = $uriArr;
    }

    public function loginView() {
        $loginFormView = new Templates(ROOT.'/templates/adminpanel/loginform.html');
        $loginFormView->replace('message',$_SESSION['message']);
        return $loginFormView->output();
    }

    public function regView() {
        $regFormView = new Templates(ROOT.'/templates/adminpanel/regform.html');
        return $regFormView->output();
    }

    public function adminView($pageAction,$userparams) {
        //главная страница админпанели
        parent::__construct(ROOT.'/templates/adminpanel/index.html');
        $this->replace('username',$userparams['login']);
        $pageActionName = $pageAction.'View';
        $this->replace('content',$this->$pageActionName());
        return $this->output();
    }

    public function userView($pageAction,$userparams) {
        //главная страница админпанели
        parent::__construct(ROOT.'/templates/adminpanel/userindex.html');
        $this->userParams = $userparams;
        $this->replace('username',$userparams['login']);
        $pageActionName = $pageAction.'View';
        $this->replace('content',$this->$pageActionName());
        if (($this->userParams['checked'] == 0) || (empty($this->userParams['checked']))) $this->replace('hide-confirm',''); else $this->replace('hide-confirm','hide');

        if (!empty($_SESSION['message'])) {
            $this->replace('message', $_SESSION['message']);
            $_SESSION['message'] = '';
            $this->replace('hide-message', '');
        }else $this->replace('hide-message', 'hide');
        return $this->output();
    }

    public function userParamView() {
        $userParamsView = new Templates(ROOT.'/templates/adminpanel/userparams.html');
        $userParamsView->replace('login',$this->userParams['login']);
        $userParamsView->replace('name',$this->userParams['name']);
        $userParamsView->replace('phone',$this->userParams['phone']);
        $userParamsView->replace('email',$this->userParams['email']);
        $userParamsView->replace('site',$this->userParams['site']);
        $userParamsView->replace('dt',$this->userParams['dt']);
        if ($this->userParams['checked']) $userParamsView->replace('checked','Да');
        else $userParamsView->replace('checked','Нет');
        return $userParamsView->output();
    }

    public function userParamEditView() {
        $userParamsView = new Templates(ROOT.'/templates/adminpanel/userparamsedit.html');
        $userParamsView->replace('id',$this->userParams['id']);
        $userParamsView->replace('login',$this->userParams['login']);
        $userParamsView->replace('name',$this->userParams['name']);
        $userParamsView->replace('phone',$this->userParams['phone']);
        $userParamsView->replace('email',$this->userParams['email']);
        $userParamsView->replace('site',$this->userParams['site']);
        $userParamsView->replace('url',$this->uriArr['0']);
        if ($this->userParams['checked']) $userParamsView->replace('checked','Да');
        else $userParamsView->replace('checked','Нет');
        return $userParamsView->output();
    }

    public function indexView() {
        $indexView = new Templates(ROOT.'/templates/adminpanel/main.html');
        return $indexView->output();
    }

    public function userIndexView() {
        $indexView = new Templates(ROOT.'/templates/adminpanel/usermain.html');
        return $indexView->output();
    }

    public function indexOrgView() {
        require_once (ROOT.'/inc/views/OrgView.php');
        require_once (ROOT.'/inc/models/OrgModel.php');
        $orgObj = new OrgModel();
        if (!empty($this->uriArr[2])) { // если есть номер страницы
            $orgsArr = $orgObj->getOrgs($this->uriArr[2],50);
            return OrgView::listOrgView($orgsArr,$orgObj->totalPages,$this->uriArr[2]);
        }else {
            $orgsArr = $orgObj->getOrgs(1,50);
            return OrgView::listOrgView($orgsArr,$orgObj->totalPages,1);
        }
    }

    public function indexUserView() {
        require_once (ROOT.'/inc/views/UserView.php');
        require_once (ROOT.'/inc/models/UserModel.php');
        $userObj = new UserModel();
        if (!empty($this->uriArr[2])) { // если есть номер страницы
            $usersArr = $userObj->getUsers($this->uriArr[2],50);
            return UserView::listUserView($usersArr,$userObj->totalPages,$this->uriArr[2]);
        }else {
            $usersArr = $userObj->getUsers(1,50);
            return UserView::listUserView($usersArr,$userObj->totalPages,1);
        }
    }

    public function editOrgView() {
        require_once (ROOT.'/inc/views/OrgView.php');
        require_once (ROOT.'/inc/views/CatsView.php');
        require_once (ROOT.'/inc/models/OrgModel.php');
        $orgObj = new OrgModel();
        $org = $orgObj->getOrg($this->uriArr[1]);
        $cats = CatsView::catsSelectListView($org['cats']);
        return OrgView::editOrgView($org,$cats);
    }

    public function editUserView() {
        require_once (ROOT.'/inc/views/UserView.php');
        require_once (ROOT.'/inc/models/UserModel.php');
        $userObj = new UserModel();
        $user = $userObj->getUser($this->uriArr[1]);
        $user['url'] = $this->uriArr['0'].'/'.$this->uriArr['1'];
        return UserView::editUserView($user);
    }

    public function editConfigView() {
        require_once (ROOT.'/inc/models/ConfigModel.php');
        $configArr = ConfigModel::getConfig();
        $configView = new Templates(ROOT.'/templates/adminpanel/configedit.html');
        $configView->replace('index-title',(isset($configArr['index-title']) ? $configArr['index-title'] : ''));
        $configView->replace('descr-title',(isset($configArr['descr-title']) ? $configArr['descr-title'] : ''));
        $configView->replace('descr',(isset($configArr['descr-title']) ? $configArr['descr-title'] : ''));
        $configView->replace('width',(isset($configArr['width']) ? $configArr['width'] : ''));
        $configView->replace('length',(isset($configArr['length']) ? $configArr['length'] : ''));
        $configView->replace('siteurl',(isset($configArr['siteurl']) ? $configArr['siteurl'] : ''));
        return $configView->output();
    }

    public function addOrgView() {
        require_once (ROOT.'/inc/views/OrgView.php');
        return OrgView::addOrgView();
    }

    public function addUserView() {
        require_once (ROOT.'/inc/views/userView.php');
        return UserView::addUserView($this->uriArr['0']);
    }

    public function importView() {
        $importView = new Templates(ROOT.'/templates/adminpanel/orgimport.html');
        return $importView->output();
    }

    public function catsView() {
        require_once (ROOT.'/inc/views/CatsView.php');
        return CatsView::catsListView();
    }

}