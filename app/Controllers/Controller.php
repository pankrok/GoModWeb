<?php

namespace App\Controllers;

class Controller
{
	
	public $c;
	
	public function __construct($container)
	{
		$this->c = $container;
	}

	public function __get($property)
	{
		return $this->c[$property];
	}
}