<?php
class OrgView extends Templates {

    public static function listOrgView($orgList,$pages,$activePage) {
        $orgListView = new Templates(ROOT.'/templates/adminpanel/orglist.html');
        $orgListHtml = '<thead><tr><th>Id</th><th>Дата добавления</th><th>Название</th><th>Мобильный</th><th>Категории</th><th>Сайт</th><th>Email</th><th>Функции</th></tr></thead>';
        foreach ($orgList as $org) {
            $orgListHtml .= '<tr><td>'.$org['id'].'</td><td>'.$org['dt'].'</td><td>'.$org['name'].'</td><td>'.$org['mobile'].'</td>
                                   <td>'.$org['cats'].'</td><td>'.$org['site'].'</td>
                                   <td>'.$org['email'].'</td>
                                   <td>
                                       <a href="/adminpanel/organizations/'.$org['id'].'/edit"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></a>
                                       <a data-id="'.$org['id'].'" href="/adminpanel/organizations/'.$org['id'].'/delete" class="delorg"><i class="fa fa-trash fa-2x" aria-hidden="true"></i></a>
                                   </td>
                             </tr>';
        }
        $orgListView->replace('orgList',$orgListHtml);

        $pagesHtml = '';
        for ($i=1;$i<=$pages;$i++) {
            if ($i == $activePage) $pagesHtml .= '<li class="footable-page active"><a href="/adminpanel/organizations/">'.$i.'</a></li>';
            else $pagesHtml .= '<li class="footable-page"><a href="/adminpanel/organizations/page/'.$i.'">'.$i.'</a></li>';
        }
        if ($activePage == 1) {
            $pagesHtml = '<li class="footable-page-arrow disabled"><a data-page="first" href="/adminpanel/organizations/">«</a></li><li class="footable-page-arrow disabled"><a data-page="prev" href="/adminpanel/organizations/">‹</a></li>'.$pagesHtml;
            $pagesHtml .= '<li class="footable-page-arrow"><a data-page="next" href="/adminpanel/organizations/page/2">›</a></li><li class="footable-page-arrow"><a data-page="last" href="/adminpanel/organizations/page/'.$pages.'">»</a></li>';
        }elseif ($activePage == $pages) {
            $pagesHtml = '<li class="footable-page-arrow"><a data-page="first" href="/adminpanel/organizations/">«</a></li><li class="footable-page-arrow"><a data-page="prev" href="/adminpanel/organizations/page/'.($pages-1).'">‹</a></li>'.$pagesHtml;
            $pagesHtml .= '<li class="footable-page-arrow disabled"><a data-page="next" href="/adminpanel/organizations/page/'.$pages.'">›</a></li><li class="footable-page-arrow disabled"><a data-page="last" href="/adminpanel/organizations/page/'.$pages.'">»</a></li>';
        }else {
            $pagesHtml = '<li class="footable-page-arrow"><a data-page="first" href="/adminpanel/organizations/">«</a></li><li class="footable-page-arrow"><a data-page="prev" href="/adminpanel/organizations/page/'.($activePage-1).'">‹</a></li>'.$pagesHtml;
            $pagesHtml .= '<li class="footable-page-arrow"><a data-page="next" href="/adminpanel/organizations/page/'.($activePage+1).'">›</a></li><li class="footable-page-arrow"><a data-page="last" href="/adminpanel/organizations/page/'.$pages.'">»</a></li>';
        }

        $orgListView->replace('pages',$pagesHtml);
        return $orgListView->output();
    }

    public static function editOrgView($org) {
        $orgListView = new Templates(ROOT.'/templates/adminpanel/orgedit.html');
        $orgListView->replace('name',$org['name']);
        $orgListView->replace('fullname',$org['fullname']);
        $orgListView->replace('descr',$org['descr']);
        $orgListView->replace('cats',$org['cats']);
        $orgListView->replace('address',$org['address']);
        $orgListView->replace('prim',$org['prim']);
        $orgListView->replace('mobile',$org['mobile']);
        $orgListView->replace('phones',$org['phones']);
        $orgListView->replace('fax',$org['fax']);
        $orgListView->replace('site',$org['site']);
        $orgListView->replace('email',$org['email']);
        $orgListView->replace('width',$org['width']);
        $orgListView->replace('length',$org['length']);
        $orgListView->replace('facebook',$org['facebook']);
        $orgListView->replace('instagram',$org['instagram']);
        $orgListView->replace('twitter',$org['twitter']);
        $orgListView->replace('vk',$org['vk']);
        $orgListView->replace('grafik',$org['grafik']);
        $orgListView->replace('yslugi',$org['yslugi']);
        $orgListView->replace('opisanie',$org['opisanie']);
        $orgListView->replace('metro',$org['metro']);
        $orgListView->replace('dometro',$org['dometro']);
        $orgListView->replace('id',$org['id']);
        return $orgListView->output();
    }

    public static function addOrgView() {
        $orgListView = new Templates(ROOT.'/templates/adminpanel/orgedit.html');
        $orgListView->replace('name','');
        $orgListView->replace('fullname','');
        $orgListView->replace('descr','');
        $orgListView->replace('cats','');
        $orgListView->replace('address','');
        $orgListView->replace('prim','');
        $orgListView->replace('mobile','');
        $orgListView->replace('phones','');
        $orgListView->replace('fax','');
        $orgListView->replace('site','');
        $orgListView->replace('email','');
        $orgListView->replace('width','');
        $orgListView->replace('length','');
        $orgListView->replace('facebook','');
        $orgListView->replace('instagram','');
        $orgListView->replace('twitter','');
        $orgListView->replace('vk','');
        $orgListView->replace('grafik','');
        $orgListView->replace('yslugi','');
        $orgListView->replace('opisanie','');
        $orgListView->replace('metro','');
        $orgListView->replace('dometro','');
        $orgListView->replace('id','0');
        return $orgListView->output();
    }
}