<?php

namespace App\Core;

class CoreRouter
{

	protected $shortUrl;	
	protected $main;
	protected $routes;
	protected $e404;

	private function routePraser($url)
	{
		$opt = strpos( $url, '{');

		if($opt)
		{
			preg_match('/{(.*?)}/', $url, $match);
			$url = substr($url, 0, $opt);
			
			if(@$match[1] && strstr($match[1], '/'))
			{
				$match[1] = str_replace('[', '', $match[1]);
				$match[1] = str_replace(']', '', $match[1]);
				$match = explode('/', $match[1]);
				if($match[0] == '')
					$match = array_slice($match, 1);
			}
			
		}
		else
		{
			$match = null;
		}
		
		if(substr($url, -1) == '/')
			$url = substr($url, 0, -1);
		
		$return['route'] = $url;
		$return['params'] = $match;
		
		return $return;
	}
	
	public function __construct($shortUrl = false)
	{	
		$this->main = substr($_SERVER['PHP_SELF'], 0, -23);
		if($shortUrl)
		{
			$this->shortUrl = true;
		}
		else
		{
			$this->shortUrl = false;
		}
		
		$this->e404 = [
			'code' 	=> 	404,
			'message' 	=> 	'<center><h1><font size="36">404</font></h1>
							<p>Page not found</p><p>back to <a href="'.BASE_URL.'">homepage</a></p></center>'
			];
	}
	
	public function addRoute($route, $controller)
	{
		$params = null;
		if($this->shortUrl)
		{
			$hendler = self::routePraser($route);
			$route = $hendler['route'];
			$params = $hendler['params'];
		}
		if($route == '') $index = '/';
			
		$this->routes[$route] = new CoreRouteModel($route, $controller, $params);	
	}
	
	public function getRoute(&$container)
	{
		if($this->shortUrl)
		{
			self::newRouter($container);
		}
		else
		{
			self::oldRouter($container);
		}
	}
	
	public function redirect($route, $code = 302)
	{
		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
		if(!isset($route)) return false;
		$url = ($actual_link .'/'. $route);
		header('Location: ' . $url, true, $code); 
		exit();
	}
	
	protected function setE404($code, $message)
	{
		if(isset($code) && isset($message))
			$this->e404 = [
				'code' 		=> 	$code,
				'message' 	=> 	$message
			];
	}

	protected function oldRouter(&$container)
	{
		/*
		* trzeba zmodernizować ;/
		*/
		$get = null;
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(@strpos($url[1], '&'))
		{
			$get = substr(strstr($url[1], '&'),1); 
			$url[1] = strstr($url[1], '&', true);
			}
		@($url[1] != '') ? $url = $url[1] : $url = '/';
		@$controller = explode(':', $this->routes[$url]->getController());
	
		@$f = $controller[1];
		$controller = $controller[0];
		if(!empty($container[$controller]))
		{
			echo $container[$controller]->$f($_POST, $_GET); 
		}
		else
		{
			http_response_code(404);
			echo '<center><h1><font size="36">404</font></h1>
			<p>Page not found</p>
			<p><a href="'.BASE_URL.'">go bck to homepage</a></p></center>';
		}
	}
	
	protected function newRouter(&$container)
	{
		$params = null;
		$url = substr($_SERVER['REQUEST_URI'], 1);
			
		if(strstr($url, '/', true))
		{
			$find = false;
			$url = explode('/', $url);
			$urlCount = count($url);
			$urlCheck = $url[0];
			
			for($i = 1; $i < $urlCount; $i++)
			{
				foreach($this->routes as $route)
				{
					if($urlCheck === $route->getUrl())
					{	
						$find = true;
						break;
					}
				}
				if($find === true)
					break;
				
				$urlCheck .= '/'.$url[$i];
			}
			
		}
		else
		{
			$urlCheck = $url;
			$i = 0;
			foreach($this->routes as $route)
				{
					if($urlCheck === $route->getUrl())
					{	
						break;
					}
				}
		}
		
		if(isset($this->routes[$urlCheck]))
		{
			
			if(is_array($url))
			if($count = $this->routes[$urlCheck]->countParams())
			{
				$data = array_slice($url, $i);
				$p = $this->routes[$urlCheck]->getParams();
				
				for($i = 0; $i < $count; $i++)
				{		
					if(@$data[$i] != null && $p[$i] != null)
						$params[$p[$i]] = htmlspecialchars($data[$i]);
				}
			}	
			
			@$controller = explode(':', $this->routes[$urlCheck]->getController());
			
			@$f = $controller[1];
			$controller = $controller[0];
			if(!empty($container[$controller]))
			{
				echo $container[$controller]->$f($_POST, $params); 
			}
			
		}
		else
		{
			http_response_code($this->e404['code']);
			echo $this->e404['message'];
		}
	}
}