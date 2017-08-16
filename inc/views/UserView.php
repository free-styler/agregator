<?php
class UserView extends Templates {

    public static function listUserView($userList,$pages,$activePage) {
        $userListView = new Templates(ROOT.'/templates/adminpanel/userslist.html');
        $userListHtml = '<thead><tr><th>Id</th><th>Логин</th><th>Имя</th><th>Телефон</th><th>Email</th><th>Сайт</th><th>Дата добавления</th><th>Подтвержден</th><th>Функции</th></tr></thead>';
        foreach ($userList as $user) {
            $userListHtml .= '<tr><td>'.$user['id'].'</td><td>'.$user['login'].'</td><td>'.$user['name'].'</td><td>'.$user['phone'].'</td>
                                   <td>'.$user['email'].'</td><td>'.$user['site'].'</td>
                                   <td>'.$user['dt'].'</td><td>'.(($user['checked']) ? 'Да' : 'Нет').'</td>
                                   <td>
                                       <a href="/adminpanel/users/'.$user['id'].'/edit"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></a>
                                       <a data-id="'.$user['id'].'" href="/adminpanel/users/'.$user['id'].'/delete" class="delorg"><i class="fa fa-trash fa-2x" aria-hidden="true"></i></a>
                                   </td>
                             </tr>';
        }
        $userListView->replace('userList',$userListHtml);

        $pagesHtml = '';
        for ($i=1;$i<=$pages;$i++) {
            if ($i == $activePage) $pagesHtml .= '<li class="footable-page active"><a href="/adminpanel/users/">'.$i.'</a></li>';
            else $pagesHtml .= '<li class="footable-page"><a href="/adminpanel/users/page/'.$i.'">'.$i.'</a></li>';
        }
        if ($activePage == 1) {
            $pagesHtml = '<li class="footable-page-arrow disabled"><a data-page="first" href="/adminpanel/users/">«</a></li><li class="footable-page-arrow disabled"><a data-page="prev" href="/adminpanel/users/">‹</a></li>'.$pagesHtml;
            $pagesHtml .= '<li class="footable-page-arrow"><a data-page="next" href="/adminpanel/users/page/2">›</a></li><li class="footable-page-arrow"><a data-page="last" href="/adminpanel/users/page/'.$pages.'">»</a></li>';
        }elseif ($activePage == $pages) {
            $pagesHtml = '<li class="footable-page-arrow"><a data-page="first" href="/adminpanel/users/">«</a></li><li class="footable-page-arrow"><a data-page="prev" href="/adminpanel/users/page/'.($pages-1).'">‹</a></li>'.$pagesHtml;
            $pagesHtml .= '<li class="footable-page-arrow disabled"><a data-page="next" href="/adminpanel/users/page/'.$pages.'">›</a></li><li class="footable-page-arrow disabled"><a data-page="last" href="/adminpanel/users/page/'.$pages.'">»</a></li>';
        }else {
            $pagesHtml = '<li class="footable-page-arrow"><a data-page="first" href="/adminpanel/users/">«</a></li><li class="footable-page-arrow"><a data-page="prev" href="/adminpanel/users/page/'.($activePage-1).'">‹</a></li>'.$pagesHtml;
            $pagesHtml .= '<li class="footable-page-arrow"><a data-page="next" href="/adminpanel/users/page/'.($activePage+1).'">›</a></li><li class="footable-page-arrow"><a data-page="last" href="/adminpanel/users/page/'.$pages.'">»</a></li>';
        }

        $userListView->replace('pages',$pagesHtml);
        return $userListView->output();
    }

    public static function editUserView($user) {
        $userListView = new Templates(ROOT.'/templates/adminpanel/userparamsedit.html');
        $userListView->replace('name',$user['name']);
        $userListView->replace('login',$user['login']);
        $userListView->replace('phone',$user['phone']);
        $userListView->replace('email',$user['email']);
        $userListView->replace('site',$user['site']);
        $userListView->replace('dt',$user['dt']);
        $userListView->replace('checked',(($user['checked']) ? 'Да' : 'Нет'));
        $userListView->replace('id',$user['id']);
        $userListView->replace('url',$user['url']);
        return $userListView->output();
    }

    public static function addUserView($url) {
        $userListView = new Templates(ROOT.'/templates/adminpanel/userparamsedit.html');
        $userListView->replace('name','');
        $userListView->replace('login','');
        $userListView->replace('phone','');
        $userListView->replace('email','');
        $userListView->replace('site','');
        $userListView->replace('dt','');
        $userListView->replace('checked','Нет');
        $userListView->replace('id',0);
        $userListView->replace('url',$url);
        return $userListView->output();
    }
}