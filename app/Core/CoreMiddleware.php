<?php

namespace App\Core;

class CoreMiddleware
{
	
	protected $middleware;
	
	public function __construct()
	{
		$this->middleware = new \stdClass();
	}
	
	public function add($object)
	{
		
		$this->middleware->{get_class($object)} = $object;
		
	}
	
	public function init()
	{
		foreach($this->middleware as $obj)
		{
			if(is_callable(
				[$obj, 'middleware'],
				true, 
				$function
			))
			$obj->middleware();
		}
	}	
	
}