<?php

class OrgModel {

    public $totalRows;
    public $totalPages;

    public function __construct() {

    }

    public static function import($org) {
        if (!empty($org)) {
            DB::getInstance()->query('INSERT INTO organizations VALUES(null,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,now())',
                $org['name'],$org['fullname'],$org['descr'],0,$org['cats'],$org['city'],$org['address'],$org['prim'],$org['mobile'],
                $org['phones'],$org['fax'],$org['site'],$org['email'],$org['width'],$org['length'],$org['facebook'],$org['instagram'],
                $org['twitter'],$org['vk'],$org['grafik'],$org['yslugi'],$org['opisanie'],$org['metro'],$org['dometro']);
        }
        return true;
    }

    public static function getAllOrgsForJson() {
        $orgsArr = DB::getInstance()->query('SELECT id,fullname,descr,mobile,site,email,cats,dt,width,length FROM organizations ORDER BY id');
        $orgsJsonArr = array('type'=>'FeatureCollection','features'=>array());
        $featuresArr = array();
        foreach ($orgsArr as $org) {
            $featuresTmp = array();
            $featuresTmp = array('type'=>'Feature','id'=>$org['id'],'geometry'=>array('type'=>'Point','coordinates'=>array($org['width'],$org['length'])),
                /*'properties'=>array('balloonContentHeader'=>'',
                                    'balloonContentBody'=>'<p>'.$org['fullname'].'</p><p>'.$org['descr'].'</p>',
                                    'balloonContentFooter'=>'<p>'.$org['mobile'].'</p>',
                                    'hintContent'=>$org['fullname'])*/
                'properties'=>array('balloonContentHeader'=>$org['fullname'],'hintContent'=>$org['fullname'],
                                    'balloonContent'=> $org['fullname'])
            );
            $featuresArr[] = $featuresTmp;

        }
        $orgsJsonArr['features'] = $featuresArr;

        return json_encode($orgsJsonArr);
    }

    public function getOrgs($pageNum,$count) {
        $totalRows = 0;
        $orgArr = DB::getInstance()->selectPage($totalRows,'SELECT id,name,mobile,site,email,cats,dt FROM organizations ORDER BY id DESC LIMIT ?d, ?d',($pageNum-1)*$count, $count);
        $pages = ceil($totalRows / $count);
        $this->totalPages = $pages;
        $this->totalRows = $totalRows;
        return $orgArr;
    }

    public function getOrg($id) {
        $org = DB::getInstance()->selectRow('SELECT * FROM organizations WHERE id=?',$id);
        return $org;
    }

    public static function saveOrg($org) {
        if ($org['id'] == 0) {
            DB::getInstance()->query('INSERT INTO organizations VALUES(null,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,now())',
                $org['name'],$org['fullname'],$org['descr'],0,$org['cats'],'',$org['address'],$org['prim'],$org['mobile'],
                $org['phones'],$org['fax'],$org['site'],$org['email'],$org['width'],$org['length'],$org['facebook'],$org['instagram'],
                $org['twitter'],$org['vk'],$org['grafik'],$org['yslugi'],$org['opisanie'],$org['metro'],$org['dometro']);
        }else DB::getInstance()->query('UPDATE organizations SET name=?, fullname=?, descr=?, cats=?, address=?, prim=?, mobile=?, phones=?, fax=?, site=?, email=?, width=?, length=?, facebook=?, instagram=?, twitter=?, vk=?, grafik=?, yslugi=?, opisanie=?, metro=?, dometro=? WHERE id=?',
            $org['name'],$org['fullname'],$org['descr'],$org['cats'],$org['address'],$org['prim'],$org['mobile'],
            $org['phones'],$org['fax'],$org['site'],$org['email'],$org['width'],$org['length'],$org['facebook'],$org['instagram'],
            $org['twitter'],$org['vk'],$org['grafik'],$org['yslugi'],$org['opisanie'],$org['metro'],$org['dometro'],$org['id']);
    }

    public static function delOrg($id) {
        DB::getInstance()->query('DELETE FROM organizations WHERE id=?',$id);
    }

}