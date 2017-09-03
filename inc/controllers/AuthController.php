<?php
	class AuthController  {
	
		private $loginName;
		private $email;
		private $loginId;
		private $is_auth;
		private $siteadmin;
		private $checked;
		
		function __construct(){
			$this->getSession();
		}
		
		function __destruct() {
			$this->setSession();
		}
		
		function getSession() {
			
			if (!empty($_SESSION['loginName'])) {
				$this->loginName = $_SESSION['loginName'];
				$this->email = $_SESSION['email'];
				$this->loginId = intval($_SESSION['loginId']);
				$this->is_auth = $_SESSION['is_auth'];
                $this->siteadmin = $_SESSION['siteadmin'];
                $this->checked = $_SESSION['checked'];
			}else {
				$this->loginName = '';
				$this->email = '';
				$this->loginId = 0;
				$this->is_auth = false;
                $this->siteadmin = false;
                $this->checked = false;
			}
		}
		
		function setSession() {
			$_SESSION['loginName'] = $this->loginName;
			$_SESSION['email'] = $this->email;
			$_SESSION['loginId'] = $this->loginId;
			$_SESSION['is_auth'] = $this->is_auth;
            $_SESSION['siteadmin'] = $this->siteadmin;
            $_SESSION['checked'] = $this->checked;
		}
		
		function getLoginId() {
			return $this->loginId;
		}
		
		function getLoginName() {
			return $this->loginName;
		}
		
		function getEmail() {
			return $this->email;
		}
		
		function getIsAuth() {
			return $this->is_auth;
		}

		function getSiteAdmin() {
		    return $this->siteadmin;
        }

        function getChecked() {
            return $this->checked;
        }

        public function setChecked($checked) {
            $this->checked = $checked;
            $_SESSION['checked'] = $this->checked;
        }

		function getUserParams() {
		    return array('id'=>$this->loginId,'login'=>$this->loginName,'email'=>$this->email,'siteadmin'=>$this->siteadmin,'checked'=>$this->checked);
        }
		
		function checkAuth($ulogin,$uPassword)
        {
            $siteAdminParams = require_once(ROOT . '/config/siteadmin.php');
            if ($ulogin == $siteAdminParams['login']) {
                $userParam = $siteAdminParams;
                $userParam['checked'] = '1';
                $this->siteadmin = true;
            } else {
                require_once(ROOT . '/inc/models/AuthModel.php');
                $userParam = AuthModel::getUserParam($ulogin);
            }

			if (!empty($userParam)) {

				if ($userParam['password'] == md5($uPassword)) {
					
					$this->loginName = $userParam['name'];
					$this->email = $userParam['email'];
					$this->loginId = $userParam['id'];
                    $this->checked = $userParam['checked'];
					$this->is_auth = true;
					
					return true;
				}else {
					$this->loginName = '';
					$this->email = '';
					$this->loginId = 0;
					$this->is_auth = false;
                    $this->siteadmin = false;
                    $this->checked = false;
					return false;
				}
				
			}else return false;
		}
		
		function logoff() {
			$this->loginName = '';
			$this->email = '';
			$this->loginId = 0;
			$this->is_auth = false;
            $this->siteadmin = false;
		}
		
	
	}

?>