<?php

namespace App\Controllers;

class AdminController extends Controller
{

	public function login()
	{
		return $this->view->render('sites/home.twig');
	}
	
	public function postLogin($post)
	{
		AuthController::auth($post);
			
		return	$this->router->redirect('home', 302);
	}
	
	public function logout()
	{
		AuthController::logout();
		return	$this->router->redirect('home', 302);
	}
	
}
	