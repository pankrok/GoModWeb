<?php

namespace App\Controllers;

use App\Models\GoDataModel;

class HomeController extends Controller
{
	
	public function index($post, $get)
	{	
		$this->cache->setName('HomeController');
		if(!$count = $this->cache->receive('count'))
		{
			$count = GoDataModel::count();
			$this->cache->store('count', $count);
		}		
		
		$this->view->addGlobal('players', $count);
		
		
		return $this->view->render('sites/home.twig'); 
	}
	
	public function soon()
	{
		return $this->view->render('sites/soon.twig');
	}
	
	public function cache($post, $get)
	{
		if($get['type'] == 'twig')
		{
			$this->cache->clearTwigCache();
			return true;
		}
		if($get['type'] == 'objects')
		{
			$this->cache->clearCache();
			return true;
		}		
		
		return 0;
	}
	
	public function cron()
	{
		$this->cache->deleteExpired();
		return '';
	}
	
	public function redirect()
	{
		$_SESSION['messege'] = 'this is middleware message';
		return $this->router->redirect('home', 301);
	}
	
}