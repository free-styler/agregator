<?php
	class AuthController  {
	
		private $loginName;
		private $email;
		private $loginId;
		private $is_auth;
		private $siteadmin;
		
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
			}else {
				$this->loginName = '';
				$this->email = '';
				$this->loginId = 0;
				$this->is_auth = false;
                $this->siteadmin = false;
			}
		}
		
		function setSession() {
			$_SESSION['loginName'] = $this->loginName;
			$_SESSION['email'] = $this->email;
			$_SESSION['loginId'] = $this->loginId;
			$_SESSION['is_auth'] = $this->is_auth;
            $_SESSION['siteadmin'] = $this->siteadmin;
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

		function getUserParams() {
		    return array('id'=>$this->loginId,'login'=>$this->loginName,'email'=>$this->email,'siteadmin'=>$this->siteadmin);
        }
		
		function checkAuth($ulogin,$uPassword)
        {
            $siteAdminParams = require_once(ROOT . '/siteadmin.php');
            if ($ulogin == $siteAdminParams['login']) {
                $userParam = $siteAdminParams;
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
					$this->is_auth = true;
					
					return true;
				}else {
					$this->loginName = '';
					$this->email = '';
					$this->loginId = 0;
					$this->is_auth = false;
                    $this->siteadmin = false;
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