<?php

namespace App\Controllers;

use App\Models\GoDataModel;
use App\Models\GoSkinsModel;
use App\Models\GoRanksModel;

class PlayerController extends Controller
{

	public function players($post)
	{
		$this->cache->setName('PlayerController');
		
		if(isset($post['find']) && strlen($post['find']) > 3)
		{
			if(!$count = $this->cache->receive('count' . $post['find']))
			{
				$count = GoDataModel::where('name', 'like', '%' . $post['find'] . '%')->count();
				$this->cache->store('count' . $post['find'], $count);
			}
			$paginator = new PaginatorController(
				$count
			);
			if(isset($post['page'])) $paginator->page($post['page']);
			$this->view->addGlobal('paginator', $paginator->paginate());
			
			$players = GoDataModel::where('name', 'like', '%' . $post['find'] . '%')
									->skip($paginator->getOffset())
									->take($paginator->getTake())
									->get();
			$this->view->addGlobal('players', $players);
		}
		else
		{
		
			$paginator = new PaginatorController(GoDataModel::count());
			if(isset($post['page'])) $paginator->page($post['page']);
			$this->view->addGlobal('paginator', $paginator->paginate());
				
			$players = GoDataModel::skip($paginator->getOffset())
									->take($paginator->getTake())
									->get();
									
			$this->view->addGlobal('players', $players);
		}
		
		return $this->view->render('sites/players.twig');
		
	}
	
	public function player($post, $arg)
	{		
		
		$this->cache->setName('PlayerController');
		if(!$player = $this->cache->receive('player'.$arg['id']))
		{
			$player = GoDataModel::find($arg['id']);
			if(!isset($player))
				return $this->view->render('sites/player.twig');
			$this->cache->store('player'.$arg['id'], $player);
		}
		if(!$skins = $this->cache->receive('skins'.$arg['id']))
		{
			$skins 	= GoSkinsModel::where('name', $player->name)->get()->toArray();
			$this->cache->store('skins'.$arg['id'], $skins);
		}
		if(!$rank = $this->cache->receive('rank'.$arg['id']))
		{
			$rank = GoRanksModel::where('name', $player->name)->get()->toArray();
			$this->cache->store('rank'.$arg['id'], $rank);
		}
		
		
		
		if(isset($post['update']))
		{
			$this->cache->delete('player'.$post['update']);
			$player = GoDataModel::find($post['update']);
			$player->money = $post['money'];
			$player->save();
			
			$this->view->addGlobal('message', true);
		}
		
		$this->view->addGlobal('player', $player);
		$this->view->addGlobal('skins', $skins);
		$this->view->addGlobal('rank', $rank[0]);
		return $this->view->render('sites/player.twig');
	}
	
	public function deleteWeapon($post)
	{
		
		if($post['skin'])
		{
			$this->cache->setName('PlayerController');
			GoSkinsModel::find($post['skin'])->delete();
			
			$this->cache->delete('skins'.$post['player']);
			
			return '<div class="message-green" style="display: none;">Skin została usunięta!</div>';
		}
		
	}
}