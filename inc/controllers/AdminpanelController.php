<?php

class AdminpanelController {

    private $uriArr = array();

    public function __construct($uriArr) {
        $this->uriArr = $uriArr;
    }

    public function actionView() {
        require_once (ROOT.'/inc/views/AdminpanelView.php');
        $adminpanelView = new AdminpanelView();
        //проверим авторизацию
        $authController = new AuthController();
        $userParams = $authController->getUserParams();
        if ($authController->getIsAuth()) {
            if (empty($this->uriArr)) {
                //показываем главную страницу админки
                echo $adminpanelView->adminView('index',$userParams);
            }else {
                if ($this->uriArr[0] == 'login') Redirect::go('/adminpanel', '');
                elseif ($this->uriArr[0] == 'logoff') {
                    $authController->logoff();
                    Redirect::go('/adminpanel/login', '');
                }elseif ($this->uriArr[0] == 'organizations') {
                    if (isset($this->uriArr[1])) {
                        if ($this->uriArr[1] == 'import') {
                            echo $adminpanelView->adminView('import', $userParams);
                        }
                    }else echo $adminpanelView->adminView('indexOrg', $userParams);

                }else Redirect::go('/adminpanel', ''); //если запрошенная страница не найдена, то редирект на главную
            }
        }else {
            if (empty($this->uriArr)) {
                Redirect::go('/adminpanel/login', 'Пожалуйста авторизируйтесь в системе!');
            }else {
                if ($this->uriArr[0] == 'login') {
                    if (!empty($_POST)) {
                        if ($authController->checkAuth($_POST['login'], $_POST['pass'], 0))
                            Redirect::go('/adminpanel', 'Добро пожаловать!');
                    }
                    echo $adminpanelView->loginView();
                }
            }
        }
    }

}