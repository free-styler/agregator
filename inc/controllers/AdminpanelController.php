<?php

class AdminpanelController {

    private $uriArr = array();

    public function __construct($uriArr) {
        $this->uriArr = $uriArr;
    }

    public function actionView() {
        require_once (ROOT.'/inc/views/AdminpanelView.php');

        $adminpanelView = new AdminpanelView($this->uriArr);
        //проверим авторизацию
        $authController = new AuthController();
        $userParams = $authController->getUserParams();

        if (isset($this->uriArr[0]) && ($this->uriArr[0] == 'checkaccount') ) {
            if (isset($this->uriArr[1])) {
                require_once(ROOT . '/inc/models/UserModel.php');
                $userData = UserModel::getUserByCheckkod($this->uriArr[1]);
                if (!empty($userData)) {
                    $userData['kod'] = '';
                    $userData['checked'] = '1';
                    UserModel::saveUser($userData);
                    $authController->setChecked('1');
                    Redirect::go('/adminpanel/login', 'Ваш аккаунт подтвержден!');
                }else Redirect::go('/adminpanel/login', '');
            }else Redirect::go('/adminpanel/login', '');
        }


        if ($authController->getIsAuth()) {
            if (empty($this->uriArr)) {
                //показываем главную страницу админки
                if ($userParams['siteadmin']) echo $adminpanelView->adminView('index',$userParams);
                else echo $adminpanelView->userView('userIndex',$userParams);
            }else {
                if ($this->uriArr[0] == 'login') Redirect::go('/adminpanel', '');
                elseif ($this->uriArr[0] == 'logoff') {
                    $authController->logoff();
                    Redirect::go('/adminpanel/login', '');
                }elseif ($this->uriArr[0] == 'organizations') {
                    if (isset($this->uriArr[1])) {
                        if ($this->uriArr[1] == 'import') {
                            if (!empty($_POST)) {
                                require_once (ROOT.'/inc/controllers/ImportOrg.php');
                                if (!empty($_FILES)) {
                                    $impDirPath = ImportOrg::prepareXlsxFile($_FILES);
                                    echo '{"path":"'.urlencode($impDirPath).'"}';
                                }
                                if (!empty($_POST['getCount']) && !empty($_POST['path'])) {
                                    echo $countRows = ImportOrg::getCountRowsInXlsx(urldecode($_POST['path']));
                                }
                                if (!empty($_POST['startRow'])) {
                                    $orgsArr = ImportOrg::importFromXlsx(urldecode($_POST['path']),$_POST['startRow'],$_POST['allRows']);
                                }
                                if ($_POST['ajax'] == 1) die();
                            }
                            echo $adminpanelView->adminView('import', $userParams);
                        }elseif ($this->uriArr[1] == 'page') {
                            echo $adminpanelView->adminView('indexOrg', $userParams,$this->uriArr);
                        }elseif (preg_match('/[0-9]+/',$this->uriArr[1])) {
                            require_once(ROOT . '/inc/models/OrgModel.php');
                            if ($this->uriArr[2] == 'edit') {
                                echo $adminpanelView->adminView('editOrg', $userParams,$this->uriArr);
                            }elseif ($this->uriArr[2] == 'save') {
                                if (!empty($_POST)) {
                                    OrgModel::saveOrg($_POST);
                                    Redirect::go('/adminpanel/organizations', '');
                                }else Redirect::go('/adminpanel/organizations', '');
                            }elseif ($this->uriArr[2] == 'delete') {
                                OrgModel::delOrg($this->uriArr[1]);
                                Redirect::go('/adminpanel/organizations', '');
                            }
                        }elseif ($this->uriArr[1] == 'add') {
                            echo $adminpanelView->adminView('addOrg', $userParams);
                        }
                    }else echo $adminpanelView->adminView('indexOrg', $userParams);

                }elseif ($this->uriArr[0] == 'users') {
                    require_once(ROOT . '/inc/models/UserModel.php');
                    if (isset($this->uriArr[1])) {
                        if ($this->uriArr[1] == 'page') {
                            echo $adminpanelView->adminView('indexUser', $userParams, $this->uriArr);
                        }elseif (preg_match('/[0-9]+/',$this->uriArr[1])) {
                            if ($this->uriArr[2] == 'edit') {
                                echo $adminpanelView->adminView('editUser', $userParams,$this->uriArr);
                            }elseif ($this->uriArr[2] == 'delete') {
                                UserModel::delUser($this->uriArr[1]);
                                Redirect::go('/adminpanel/users', '');
                            }elseif ($this->uriArr[2] == 'save') {
                                if (!empty($_POST)) {
                                    UserModel::saveUser($_POST);
                                    Redirect::go('/adminpanel/users', '');
                                }else Redirect::go('/adminpanel/users', '');
                            }
                        }elseif ($this->uriArr[1] == 'add') {
                            echo $adminpanelView->adminView('addUser', $userParams);
                        }
                    }else echo $adminpanelView->adminView('indexUser', $userParams,$this->uriArr);

                }elseif ($this->uriArr[0] == 'config') {
                    if (isset($this->uriArr[1])) {
                        if ($this->uriArr[1] == 'edit') {
                            echo $adminpanelView->adminView('editConfig', $userParams,$this->uriArr);
                        }elseif ($this->uriArr[1] == 'save') {
                            ConfigModel::saveConfig($_POST);
                            Redirect::go('/adminpanel/config/edit', '');
                        }
                    }else Redirect::go('/adminpanel/config/edit', '');

                }elseif ($this->uriArr[0] == 'sendmailforcheck') {
                    $kod = md5($userParams['email'].$userParams['login']);
                    include_once(ROOT . "/inc/Mail.php");
                    $configArr = ConfigModel::getConfig();
                    NewMail::sendMail('admin@admin.ru', $userParams['email'], 'Успешная регистрация в системе', 'Спасибо за регистрацию в нашей системе! Пройдите по <a href="'.$configArr['siteurl'].'/adminpanel/checkaccount/' . $kod . '">ссылке</a> для подтвержления Вашего аккаунта.');
                    Redirect::go('/adminpanel', 'Письмо для активации Вашего аккаунта успешно отправлено!');
                }elseif ($this->uriArr[0] == 'user') {
                    require_once(ROOT . '/inc/models/UserModel.php');

                    if (isset($this->uriArr[1]) && $this->uriArr[1] == 'edit') {
                        $userParams = UserModel::getUser($userParams['id']);
                        echo $adminpanelView->userView('userParamEdit', $userParams);
                    }elseif (isset($this->uriArr[1]) && $this->uriArr[1] == 'save') {
                        if (!empty($_POST)) {
                            UserModel::saveUser($_POST);
                            Redirect::go('/adminpanel/user', '');
                        }else Redirect::go('/adminpanel/user', '');
                    }else {
                        $userParams = UserModel::getUser($userParams['id']);
                        echo $adminpanelView->userView('userParam', $userParams);
                    }
                }else Redirect::go('/adminpanel', ''); //если запрошенная страница не найдена, то редирект на главную
            }
        }else {
            if (empty($this->uriArr)) {
                Redirect::go('/adminpanel/login', '');
            }else {
                if ($this->uriArr[0] == 'login') {
                    if (!empty($_POST)) {
                        if ($authController->checkAuth($_POST['login'], $_POST['pass'], 0)) {
                            Redirect::go('/adminpanel', 'Добро пожаловать!');
                        }else Redirect::go('/adminpanel/login', 'Ошибка авторизации!');
                    }
                    echo $adminpanelView->loginView();
                    $_SESSION['message'] = '';
                }elseif ($this->uriArr[0] == 'registration') {
                    if (!empty($_POST)) {
                        require_once(ROOT . '/inc/models/UserModel.php');
                        $user = UserModel::getUserByName($_POST['login']);
                        if (empty($user)) {
                            $kod = md5($_POST['email'].$_POST['login']);
                            $_POST['kod'] = $kod;
                            $configArr = ConfigModel::getConfig();
                            UserModel::saveUser($_POST);
                            include_once(ROOT . "/inc/Mail.php");
                            NewMail::sendMail('admin@admin.ru', $_POST['email'], 'Успешная регистрация в системе', 'Спасибо за регистрацию в нашей системе! Пройдите по <a href="'.$configArr['siteurl'].'/adminpanel/checkaccount/' . $kod . '">ссылке</a> для подтвержления Вашего аккаунта.');
                            Redirect::go('/adminpanel/login', 'Вы успешно зарегистрированы в системе! Войдите под своим логином и паролем.');
                        }else Redirect::go('/adminpanel/registration', 'Пользователь с таким именем уже существует!');
                    }
                    echo $adminpanelView->regView();
                }
            }
        }
    }

}