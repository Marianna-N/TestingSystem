<?php
class Dispatcher
{
	const SIT_USER_LOGGED = 1;
	const SIT_LOGOUT_INITIATED = 2;
	const SIT_LOGIN_INITIATED = 256;
	const SIT_LOGOUT_COMPLETED = 512;
	const SIT_NEW__REG_INITIATED = 600;
	const SIT_NEW_REGISTRATION = 700;
	const SIT_GENERATE_KEY = 800;
	
	
	public function detectSituation() : int
	{
		$situation = 0;
		print_r($situation);
		if ((isset($_GET['logout'])) && ($_GET['logout']=='go')) {
			$situation = $situation | Dispatcher::SIT_LOGOUT_INITIATED;
		}
		if ((isset($_POST['login']))&&(isset($_POST['password']))) {
			$situation = $situation | Dispatcher::SIT_LOGIN_INITIATED;
		}
		if ((isset($_GET['registration'])) && ($_GET['registration']=='new')){
			$situation = $situation | Dispatcher::SIT_NEW__REG_INITIATED;
		}		
		if ((isset($_POST['new_login']))&&(isset($_POST['email']))){
			$situation = $situation | Dispatcher::SIT_NEW_REGISTRATION;
		}
		if ((isset($_GET['generate_key'])) && ($_GET['generate_key']=='go')) {
			$situation = $situation | Dispatcher::SIT_GENERATE_KEY;
		}
		

		echo "situation ->";
		print_r($situation);
		echo "</br>";
		return $situation;
	}
}
