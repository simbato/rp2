<?php 

class LogoutController
{
	public function index() 
	{
		session_unset(); 
		session_destroy();
		require_once __DIR__ . '/../login.php';
	}
}; 

?>