<?php

namespace App\Controllers;

class PaginatorController
{
	
	public $items;
	public $current;
	public $take;	
	public $pages;
	public $offset;
	
	public function __construct($items, $take = 15)
	{
		$this->items = $items;
		$this->current = 0;
		$this->take = $take;
				
		$this->pages = ceil($items / $take)-1;
		$this->offset = $this->take * $this->current;
	}
	
	public function nextPage()
	{
		if($this->current < $this->pages)
			$this->current++;	
		$this->offset = $this->take * $this->current;
	}
	
	public function prevPage()
	{
		if($this->current > 0)
			$this->current--;
		$this->offset = $this->take * $this->current;
	}
	
	public function page($page)
	{
		$this->current = $page;
		$this->offset = $this->take * $this->current;
	}
	
	public function lastPage()
	{
		$this->current = $this->pages;
		$this->offset = $this->take * $this->current;
	}
	
	public function firstPage()
	{
		$this->current = 0;
		$this->offset = $this->take * $this->current;
	}
	
	public function paginate()
	{
		if($this->pages > 0)
		{
			
			if($this->current > 0 && $this->current < $this->pages )
			{
				$return['p'] = [
					$this->current-1,
					$this->current,
					$this->current+1
				];
			}
			elseif($this->current == 0 && $this->current < $this->pages )
			{
				$return['p'] = [
					$this->current,
					$this->current+1
				];
			}
			elseif($this->current > 0 && $this->current == $this->pages )
			{
				$return['p'] = [
					$this->current-1,
					$this->current
				];
			}
		}
		else
		{
			return null;
		}
		
		$return['f'] = 0;
		$return['l'] = $this->pages;
		$return['c'] = $this->current;
		return $return;
	}
	
	public function getOffset()
	{
		return $this->offset;
	}
	
	public function setOffset($offset)
	{
		return $this->offset = $offset;
	}
	
	public function getTake()
	{
		return $this->take;
	}
	
	public function setTake($take)
	{
		return $this->take = $take;
	}
}