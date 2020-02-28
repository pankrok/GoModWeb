<?php

namespace App\Core;

class CoreInit
{
	
	public $container = [];
	public $logger;
	public $middleware;
	protected $error;
	
	public function __construct($container = null)
	{		
		
		if(!$this->container = @parse_ini_file(MAIN_DIR . '/bootstrap/CoreEnv.ini', true))
			die('CoreEnv config boot error!');
		$this->error = '<h2>Application error</h2>';
		self::logger($this->container['core']['log_level']);		
		
		$go_skins = new CoreSkinsLoader($container['go_skins_path']);
		
		$this->container['main'] = $container;
		
			$loader = new \Twig\Loader\FilesystemLoader(MAIN_DIR . '/public/skins');
			$twig = new \Twig\Environment(
				$loader, 
				self::twigCfg($this->container['twig']['twig_cache']));
			
			$twig->addGlobal('base_url', BASE_URL);
			$twig->addGlobal('go_skins', $go_skins->getSkinsList());
			$twig->addGlobal('v', base64_decode($this->container['core']['version']));
			$twig->addGlobal('show_version', $this->container['core']['show_version']);
		
		$this->container['view'] 		= $twig;
		$this->container['router'] 		= new CoreRouter($container['newRouter']);
		$this->container['cache'] 		= new CoreCache($this->container['cache']);
		$this->middleware				= new CoreMiddleware();
		
		return $this->container;
	}
	
	public function add($function, $container)
	{
		$this->container[$function] = $container;
		return $container;
	}
	
	public function get($function = null)
	{
		if(isset($function)){
			return $this->container[$function];
		}
		else
		{
			return $this->container;
		}
	}
	
	public function route($route, $controller)
	{
		$this->container['router']->addRoute($route, $controller);
	}
		
	public function run()
	{

		try {
			$this->middleware->init();
			$this->container['router']->getRoute($this->container);
		} catch (\Exception $e) {
			$this->logger->error($e->getTraceAsString());
			if($this->container['core']['debug'])
			{
				echo '<h2>Caught exception:</h2>Stack trace:<br />',  str_replace('#', "<br />#", $e->getTraceAsString());
			}
			else
			{
				echo $this->error;
			}
			
		}	
	}
	
	protected function editErrorMessage($message)
	{
		if(isset($message))
			$this->error = $message;
	}
	
	protected function logger($level)
	{
		$this->logger = new \Monolog\Logger('GoPanel');
		$formatter = new \Monolog\Formatter\LineFormatter(
			"[%datetime%] %channel%.%level_name%: \n%message% %context% %extra%\n", // Format of message in log, default [%datetime%] %channel%.%level_name%: %message% %context% %extra%\n
			null, // Datetime format
			true, // allowInlineLineBreaks option, default false
			true  // ignoreEmptyContextAndExtra option, default false
		);
		
		switch ($level) {
			case '0':
				$debugHandler = (new \Monolog\Handler\StreamHandler(MAIN_DIR.'/bootstrap/logs/error.log.txt', \Monolog\Logger::ERROR));
				break;
			case '1':
				$debugHandler =(new \Monolog\Handler\StreamHandler(MAIN_DIR.'/bootstrap/logs/error.log.txt', \Monolog\Logger::NOTICE));
				break;
			case '2':
				$debugHandler =(new \Monolog\Handler\StreamHandler(MAIN_DIR.'/bootstrap/logs/error.log.txt', \Monolog\Logger::INFO));
				break;
			case '3':
				$debugHandler =(new \Monolog\Handler\StreamHandler(MAIN_DIR.'/bootstrap/logs/error.log.txt', \Monolog\Logger::DEBUG));
				break;
			default:
				$debugHandler =(new \Monolog\Handler\StreamHandler(MAIN_DIR.'/bootstrap/logs/error.log.txt', \Monolog\Logger::CRITICAL));
		}
		
		$debugHandler->setFormatter($formatter);
		$this->logger->pushHandler($debugHandler);
		
	}
	
	protected function twigCfg($set)
	{
		if($set == 0)
		{
			$cfg = false;
		}
		else
		{
			$cfg = MAIN_DIR . '/bootstrap/cache/skins';
		}
		
		return [
			'cache' => $cfg
		];
	}
	
}