<?php
class UserModel {
    public $totalRows;
    public $totalPages;

    public static function saveUser($userData) {
        if (isset($userData['id'])) {
            $password = '';
            if (isset($userData['pass-confirm']) && !empty($userData['pass'])) {
                if ($userData['pass-confirm'] == $userData['pass']) {
                    $password = md5($userData['pass']);
                }
            }elseif (isset($userData['pass']) && !empty($userData['pass'])) {
                $password = md5($userData['pass']);
            }
            DB::getInstance()->query('UPDATE users SET login=?, name=?, phone=?, email=?, site=? {, password=?} WHERE id=?',$userData['login'],$userData['name'],$userData['phone'],$userData['email'],$userData['site'],($password=='' ? DBSIMPLE_SKIP : $password),$userData['id']);
        }else {
            DB::getInstance()->query('INSERT users VALUES(null,?,?,?,?,?,?,?,0,now())',$userData['login'],md5($userData['pass']),$userData['login'],'','','',$_SERVER['REMOTE_ADDR']);
        }
    }

    public static function getUser($id) {
        $userParams = DB::getInstance()->selectRow('SELECT * FROM users WHERE id=?',$id);
        return $userParams;
    }

    public function getUsers($pageNum,$count) {
        $totalRows = 0;
        $usersArr = DB::getInstance()->selectPage($totalRows,'SELECT * FROM users ORDER BY id DESC LIMIT ?d, ?d',($pageNum-1)*$count, $count);
        $pages = ceil($totalRows / $count);
        $this->totalPages = $pages;
        $this->totalRows = $totalRows;
        return $usersArr;
    }

    public static function delUser($id) {
        DB::getInstance()->query('DELETE FROM users WHERE id=?',$id);
    }

}