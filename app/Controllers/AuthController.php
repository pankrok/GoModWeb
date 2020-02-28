<?php

namespace App\Controllers;

class AuthController
{
	
	public static function auth($data)
	{
		if(!isset($data['password']) || !isset($data['login'])) return false;
		$user = [
			'yuri' => '772d879091a0390db69435010f8ff8bb', // Colt1911
			'fejm' => 'ec53bd3f7696d41d23abf652b6188bdf', // Smok2018
			//'baleron' => '1ffb09ac450d97441d1f608e2476b0c6'// Pork2018
		];
		
		if(!isset($user[$data['login']])) return false;
		if($user[$data['login']] !== md5($data['password'])) return false;
		$_SESSION['user'] = true;
		return $_SESSION['user'];
		
	}
	
	public function check()
	{
		if(isset($_SESSION['user'])) return true;
	}
	
	public static function logout()
	{
		$_SESSION['user'] = null;
		return true;
	}
	
}