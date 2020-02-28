<?php

namespace App\Core;

class CoreSkinsLoader
{

	protected $skins;

	public function __construct($link)
	{
		if(file_exists(MAIN_DIR . $link))
			$this->skins = (self::goWeapons(MAIN_DIR . $link));
	}
	
	public function getSkinsList()
	{
		return $this->skins;
	}
	
	protected function goWeapons($f)
	{
		$arr = [];
		$cat = null;
		if ($file = fopen($f, "r")) {
			while(!feof($file)) {
				$line = fgets($file);
				$data = self::goPraser($line);
				
				if(isset($data['main']))
				{
					$arr += [$data['main'] => []];
					$cat = $data['main'];
				}
				if(isset($data['second']))
				{
					array_push($arr[$cat], $data['second']); 
				}
				$data = null;
			}
			fclose($file);
		}
		else
		{
			echo 'file read error';
		}	
		return $arr;
	}

	protected function goPraser($line)
	{
		$arr = [];
		//check is it comment
		$comment = strpos($line, ';');
		if($comment !== false)
			$line = substr($line, 0, $comment);
		//check is it weapons category eg FAMAS
		$category = strpos($line, '-');
		if($category !== false && $category != '[Wszystkie ')
		{
			$category = substr($line, 1, $category-2);
			$arr = ['main' => $category];
		}
		//check is it a weapon name
		$weapon = strpos($line, 'models'); 
		if($weapon !== false)
		{
			preg_match('/"(.*?)"/', $line, $match);
			$arr = ['second' => $match[1]];
		}
		return $arr;
	}
	
}
