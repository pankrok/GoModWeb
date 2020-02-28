<?php

namespace App\Controllers\Middleware;

use App\Controllers\Controller;

class MessageMiddlewareController extends Controller
{
	
	public function middleware()
	{

		if(isset($_SESSION['messege']))
		{
			
			$this->view->addGlobal('message', $_SESSION['messege']);
			unset($_SESSION['messege']);
			
		}
		
	}
	
}