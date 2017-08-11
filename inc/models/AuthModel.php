<?php
class AuthModel {

    public function __construct() {

    }

    public static function getUserParam($ulogin) {
       return $userParam =  DB::getInstance()->selectRow('SELECT id,name,password,email FROM users WHERE login=?',$ulogin);
    }

}