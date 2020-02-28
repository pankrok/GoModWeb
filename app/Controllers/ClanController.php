<?php

namespace App\Controllers;

use App\Models\GoClansModel;

class ClanController extends Controller
{
	
	public function clanList($post, $get)
	{
		$paginator = new PaginatorController(GoClansModel::count());
		if(isset($get['page'])) $paginator->page($get['page']);
		$this->view->addGlobal('paginator', $paginator->paginate());
			
		$clans = GoClansModel::skip($paginator->getOffset())
								->take($paginator->getTake())
								->get();
								
		$this->view->addGlobal('clans', $clans);
		return $this->view->render('sites/clans.twig');
	}
	
}