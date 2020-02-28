<?php

namespace App\Controllers;

use App\Models\GoDataModel;
use App\Models\GoSkinsModel;

class SkinController extends Controller
{
	
	public function list()
	{	
		return $this->view->render('sites/skins.twig'); 
	}
	
	public function skin($post, $get)
	{	
		$name = rawurldecode($get['name']);
			
		if( file_exists(MAIN_DIR . '/public/img/weapons/'. $name .'.png') )
		{
			$url = '<img src="'.BASE_URL . '/public/img/weapons/' . $get['name'] .'.png">';
		}
		else
		{
			$url = 'Sorry no IMG';
		}	
		$this->view->addGlobal('skin_name', $name);
		$this->view->addGlobal('skin_img', $url);
		
		return $this->view->render('sites/skin_details.twig');
	}
	
	public function addPlayerSkin($post)
	{
		if(isset($post['player_id']) && isset($post['skin']))
		{
			$go_skins = new CoreSkinsLoader($container['go_skins_path']);
			if(array_search($post['skin'], $go_skins))
			{
				if($player = GoDataModel::find($post['player_id']))
				{
					
					if($weapon = GoSkinsModel::where(
					['name', 'skin'],[$player->name, $post['skin']]
					)->get()){
						++$weapon->count;
						$weapon->save();
						
						if($post['ajax'])
							return 'skin został dodany';
						
						$_SESSION['message'] = json_encode('skin został dodany');
						return $this->router->redirect('player/'.$post['player_id'], 301);
						
					}
					
					if(GoSkinsModel::create([
						'name' 		=> $player->name,
						'weapon' 	=> $post['weapon'],
						'skin'		=> $post['skin'],
						'count'		=> '1'
					]))
					if($post['ajax'])
							return 'skin został dodany';
						
					$_SESSION['message'] = json_encode('skin został dodany');
					return $this->router->redirect('player/'.$post['player_id'], 301);
				}
				return false;
				
			}
			return false;
			
		}
		return false;
		
	}
	
	
}