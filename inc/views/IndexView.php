<?php

require_once(ROOT.'/inc/Templates.php');

class IndexView extends Templates {

	public function __construct() {
		parent::__construct(ROOT.'/templates/index/index.html');
	}

	public function actionView($orgsArr) {
        require_once(ROOT . '/inc/models/ConfigModel.php');
        require_once(ROOT . '/inc/models/OrgModel.php');
        require_once(ROOT . '/inc/views/OrgView.php');
        $configData = ConfigModel::getConfig();

	    $this->replace('descr-title',(isset($configData['descr-title']) ? $configData['descr-title'] : ''));
        $this->replace('descr',(isset($configData['descr']) ? $configData['descr'] : ''));
        $this->replace('title',(isset($configData['title']) ? $configData['title'] : ''));
        $orgsHtml = OrgView::orgsIndexView($orgsArr);
        $this->replace('orgs',$orgsHtml);
	    return $this->output();
    }

    public static function orgsView($orgsArr) {

    }


	/*function prepareTovarList($tovarArr,$zoneId,$kindId,$currenciesArr,$totalRows,$pagesCount) {
		
		$tovarData = '<div class="formcountposts">'.$this->prepareCountTovarByPage($pagesCount,$zoneId,$kindId).'</div>';
		$tovarData .= '<table class="mws-table"><thead><tr><th width="110">Изображение</th><th>Наимменование</th><th>Цена</th><th>Остаток</th><th width="80">Купить</th></tr></thead>';
	
		foreach ($tovarArr[0] as $tovar) {
			$imageData = '';
						
			if (!empty($tovarArr[1][$tovar['id']])) {
				$imageData = '<img src="/tovar_images/thumbs/'.$tovarArr[1][$tovar['id']][0]['imgname'].'" height="100">';
			}
			$linkToTovar = '<a href="index.php?zone='.$zoneId.'&kind='.$tovar['idkind'].'&tovar='.$tovar['id'].'">';
			$price = (!empty($tovar['price'])) ? number_format($tovar['price'], 2, ',', ' ').' '.$currenciesArr[$tovar['idcurrency']] : '';
			$tovarData .= '<tr><td>'.$linkToTovar.$imageData.'</a></td><td>'.$linkToTovar.$tovar['name'].'</a></td><td>'.$price.'</td><td>'.$tovar['availability'].'</td><td><div class="addbasket">'.$this->prepareBuyForm($zoneId,$tovar['idkind'],$tovar['id']).$linkToTovar.'<img src="template/images/scope.gif"></a></div></td></tr>';
			
			
		}
		
		if ($pagesCount == 'all') $numPages = 1;
		else $numPages = ceil($totalRows / $pagesCount);
		for($i=1;$i<=$numPages;$i++) {
			$paginationData .= '<a href="index.php?zone='.$zoneId.'&kind='.$kindId.'&page='.$i.'">'.$i.'</a>';
		}
		
		$tovarData .= '</table>';
		$tovarData .= '<div class="pagination">'.$paginationData.'</div>';
		return $tovarData;
	}*/
	

}


?>