<?php

namespace App\Core;

class CoreRouteModel
{
	
	protected $controller;
	protected $url;
	protected $params;
	protected $method; // not implemeted yet
	
	public function __construct($url, $controller, $params = null)
	{
		$this->url = $url;
		$this->controller = $controller;
		$this->params = $params;
	}
		
	public function getUrl()
	{
		return $this->url;
	}
	
	public function getController()
	{
		return $this->controller;
	}
	
	public function getParams()
	{
		return $this->params;
	}
	
	public function countParams()
	{
		return count($this->params);
	}
	
	public function countUrl()
	{
		return count($this->url);
	}
}