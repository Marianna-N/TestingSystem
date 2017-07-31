<?php
class Auth
{
	private $mysql = false;
	
	public function __construct()
	{
		$this->mysql = DataBase::getInstance();
	}
	
	public function checkUserPassword($login, $password) 
	{
		$login = trim($login);
		$id_user = NULL;
		if(strlen($password) == 40){
			return $password;
		}
		else{
			$password = trim($password);
			$password = sha1($password);
		}
		
		$users = $this->mysql->completeQuery("SELECT `u_id`,`u_login`,`u_password` FROM `user`");
		for($i=0;$i<count($users);$i++){
			if($login == $users[$i]["u_login"] and $password == $users[$i]["u_password"])
			{
				$id_user = $users[$i]["u_id"];
			}
		}
		return $id_user;
	}	
	
	public function getPermission($id_user)
	{	
		$permission_arr = $this->mysql->completeQuery('SELECT `u_permission` FROM `user` WHERE `u_id`=\''.$id_user.'\'');
		$permission = $permission_arr[0]["u_permission"];
		return $permission;
		
	}
	
	public function checkLoginByCookie()
	{
		$all_remember = $this->mysql->completeQuery("SELECT `u_login`,`u_password`,`u_remember` FROM `user`");
		for($i=0;$i<count($all_remember);$i++){
			if($_COOKIE['remember'] == $all_remember[$i]["u_remember"])
			{
				$_POST['login'] =  $all_remember[$i]["u_login"];
				$_POST['password'] = $all_remember[$i]["u_password"];
			}
		}
	}
	
	public function generateCode(int $length=40) : string
	{ 
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789"; 
		$code = ""; 
		$clen = strlen($chars) - 1;   
		while (strlen($code) < $length) { 
			$code .= $chars[mt_rand(0,$clen)];   
		} 
		return $code; 
	}
	
	public function userLogout () 
	{
		setcookie("remember", '---', -1);  //delete cookie
		unset($_SESSION['post_log']);
		unset($_SESSION['post_pass']);
		header("Location: index.php");
	}
	
	public function checkNewUser ($login, $email):array
	{
		$coincidence = array("login" => false,"email" => false);
		$login = trim($login);
		$email = trim($email);
		$users = $this->mysql->completeQuery("SELECT `u_login`,`u_email` FROM `user`");
		for($i=0;$i<count($users);$i++){
			if($login == $users[$i]["u_login"]){
				$coincidence["login"] = true;
			}
			if($email == $users[$i]["u_email"]){
				$coincidence["email"] = true;
			}
		}
		return $coincidence;	
	} 
	
	public function setNewRegistration(array $reg_data){
		$permission = 0; //default permission is like listener
		$reg_data = array_map('trim', $reg_data);
		$reg_data["password_1"] = sha1($reg_data["password_1"]);
		if($reg_data["training"] == ''){  //if user enter '' in field "training" => it means admin permission 
			$reg_data["training"] == 'admin';
			$permission = 1;
		}
		$sql = $this->mysql->prepare("INSERT INTO `user` (`u_login`, `u_password`, `u_name`, `u_lastname`, `u_training`, `u_email`, `u_permission`) VALUES (:u_login, :u_password, :u_name, :u_lastname, :u_training, :u_email, :u_permission)");
		$sql->execute(array(':u_login' => $reg_data["new_login"],
							':u_password' => $reg_data["password_1"],
							':u_name' => $reg_data["name"],
							':u_lastname' => $reg_data["lastname"],
							':u_training' => $reg_data["training"],
							':u_email' => $reg_data["email"],
							':u_permission' => $permission));
				
	}
	
	public function checkUser ($login, $permissions) : bool
	{
		$login = trim($login);
		$coincidence = false;  
		$user_names = $this->mysql->completeQuery("SELECT `u_login` FROM `user`");
		//print_r($user_names);
		for($i=0;$i<count($user_names);$i++){
			if($login == $user_names[$i]["u_login"])
			{
				$coincidence = true; //login name exists
				$sql = $this->mysql->prepare('UPDATE `user` SET `u_permission` =\''.$permissions.'\' WHERE `u_login`=\''.$login.'\'');
				$sql->execute();
			
			}
		}
		return $coincidence;
		
	}
	
}