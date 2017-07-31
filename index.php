<?php
declare(strict_types=1);
session_start();
require_once('config.php');

function __autoload(string $classname) : void
{
	require_once('class/' . $classname . '.Class.php');
}

//Error handler and exception handler.
set_error_handler(array('ErrorHandler', 'errorErrorHandler'), E_ALL);
set_exception_handler(array('ErrorHandler', 'exceptionErrorHandler'));

// Preapre objects.
$config_object = new Config();
$auth_object = new Auth();
$template_object = new Template();
$question_object = new Question();
$test_object = new Test();

$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/authorization_form.tpl');
$template_object->setPlaceholder('error_login', '');
$template_object->setPlaceholder('error_key', '');


// Process logout.
if ((isset($_GET['logout'])) && ($_GET['logout']=='go')) {
	$auth_object->userLogout();
	$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/authorization_form.tpl');
	$template_object->setPlaceholder('error_login', '');
	$template_object->setPlaceholder('error_key', '');
}
//Check cookie
if (isset($_COOKIE['remember'])){
	$auth_object->checkLoginByCookie();
	
}
// Click on link for registration.
if ((isset($_GET['registration'])) && ($_GET['registration']=='new')) {
	$template_object->setPlaceholder('error_register', '');
	$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/registration_form.tpl');
}
//Try to register 
if ((isset($_POST['new_login']))&&(isset($_POST['email']))) {
	$coincidence = $auth_object->checkNewUser($_POST['new_login'],$_POST['email']);
	if($coincidence["login"] == true){
		$template_object->setPlaceholder('error_register', $config_object->getMessageById('msg_login_exists'));
		$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/registration_form.tpl');	
	}
	if($coincidence["email"] == true){
		$template_object->setPlaceholder('error_register', $config_object->getMessageById('msg_email_exists'));
		$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/registration_form.tpl');	
	}
	if(($coincidence["email"] == true) && ($coincidence["login"] == true)){
		$template_object->setPlaceholder('error_register', $config_object->getMessageById('msg_login_email_exist'));
		$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/registration_form.tpl');
	}
	if(($coincidence["email"] == false) && ($coincidence["login"] == false)){
		$auth_object->setNewRegistration($_POST);
		$template_object->setPlaceholder('error_login', $config_object->getMessageById('msg_reg_successful'));
		$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/authorization_form.tpl');
	}
}
//Generate the key
if ((isset($_GET['generate_key'])) && ($_GET['generate_key']=='go')) {
	$key = $auth_object->generateCode(31); // 31 number, cause login can have only 30, we can separate login and key
	$template_object->setPlaceholder('generate_key', $key);
	$template_object->setPlaceholder('error_permissions', '');
	$template_object->setPlaceholder('error_assign_test', '');
	$test_object->getAllTests($template_object, $_SERVER['DOCUMENT_ROOT'].'/templates/test_link_admin.tpl');
	$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/admin_form.tpl');
}
//Assign permition
if ((isset($_POST['p_user']))&&(isset($_POST['permissions']))) {
	$coincidence = $auth_object->checkUser($_POST['p_user'],$_POST['permissions']);
	if($coincidence == true){
		$template_object->setPlaceholder('generate_key', '');
		$template_object->setPlaceholder('error_permissions', '');
		$template_object->setPlaceholder('error_assign_test', '');
		$test_object->getAllTests($template_object, $_SERVER['DOCUMENT_ROOT'].'/templates/test_link_admin.tpl');
		$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/admin_form.tpl');
	}
	else{
		$template_object->setPlaceholder('generate_key', '');
		$template_object->setPlaceholder('error_assign_test', '');
		$test_object->getAllTests($template_object, $_SERVER['DOCUMENT_ROOT'].'/templates/test_link_admin.tpl');
		$template_object->setPlaceholder('error_permissions', $config_object->getMessageById('msg_error_login'));
		$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/admin_form.tpl');
		
	}
}
//If admin go to "create a question"
if ((isset($_GET['create_question'])) && ($_GET['create_question']=='go')) {
	$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/question_form.tpl');
}
//If admin create a question type 1
if ((isset($_POST['radio-answer']))&&(isset($_POST['upload']))){
	$question_object->createQuestion($_POST,$_FILES);
	$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/question_form.tpl');
}
//If admin go to "create a test"
if ((isset($_GET['create_test'])) && ($_GET['create_test']=='go')) {
	$question_object->setQuestion($template_object, $_SERVER['DOCUMENT_ROOT'].'/templates/question.tpl', $test_object);
	$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/test_form.tpl');
}
//If admin create a test
if ((isset($_POST['test_name']))&&(isset($_POST['upload_test']))) {
	$test_object->setTest($_POST);
	$question_object->setQuestion($template_object, $_SERVER['DOCUMENT_ROOT'].'/templates/question.tpl', $test_object);
	$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/test_form.tpl');
}
//If user want to pass a test
if ((isset($_GET['test_id']))&&(isset($_GET['user_name']))&&(isset($_GET['test_name']))) {
	$_SESSION["test_name"]=$_GET['test_name'];
	$_SESSION["user_id"] = $_GET['user_name'];
	$test_object->getTest($_GET['test_id'],$template_object, $_SERVER['DOCUMENT_ROOT'].'/templates/test_questions.tpl');
	$template_object->setPlaceholder('test_name', $_GET['test_name']);
	$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/test.tpl');
}
//If user passed the test
if ((isset($_POST['pass_test']))&&($_POST['pass_test']=='Pass the Test!')){
	$test_name = $_SESSION["test_name"];
	$user_id = $_SESSION["user_id"];	
	$test_object->getTestResults($_POST,$template_object, $_SERVER['DOCUMENT_ROOT'].'/templates/results.tpl',$test_name, $user_id);
	$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/test_results.tpl');
}
//If admin want check test statistics
if ((isset($_GET['test_statistic'])) && ($_GET['test_statistic']=='go')) {
	$test_object->setTestStatistics($template_object, $_SERVER['DOCUMENT_ROOT'].'/templates/statistics_body.tpl');
	$template_object->setPlaceholder('statistics_name', 'Tests statistics');
	$template_object->setPlaceholder('header_1', 'Tests name');
	$template_object->setPlaceholder('header_2', 'Tests passes');
	$template_object->setPlaceholder('header_3', 'Average percentage(%)');
	$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/statistics.tpl');	
}
//If admin want check user statistics
if ((isset($_GET['user_statistic'])) && ($_GET['user_statistic']=='go')) {
	$test_object->setUserStatistics($template_object, $_SERVER['DOCUMENT_ROOT'].'/templates/user_statistics_body.tpl');
	$template_object->setPlaceholder('statistics_name', 'User statistics');
	$template_object->setPlaceholder('header_1', 'User name');
	$template_object->setPlaceholder('header_2', 'User lastname');
	$template_object->setPlaceholder('header_3', 'Training');
	$template_object->setPlaceholder('header_4', 'Test name');
	$template_object->setPlaceholder('header_5', 'Average percentage(%)');
	$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/user_statistics.tpl');	
}
//Admin want to look at test
if ((isset($_GET['test_id_admin']))&&(isset($_GET['test_name_admin']))) {
	$template_object->setPlaceholder('test_name', $_GET['test_name_admin']);
	$test_object->getTest($_GET['test_id_admin'],$template_object, $_SERVER['DOCUMENT_ROOT'].'/templates/test_questions.tpl');
	$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/test_admin.tpl');
}
//Admin assign test
if ((isset($_POST['test_user']))&&(isset($_POST['test']))) {
	$test_object->getAllTests($template_object, $_SERVER['DOCUMENT_ROOT'].'/templates/test_link_admin.tpl');
	$test_object->AssignTest($_POST['test_user'],$_POST['test'],$template_object,$config_object);
	$template_object->setPlaceholder('generate_key', '');
	$template_object->setPlaceholder('error_permissions', '');
	$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/admin_form.tpl');
}
//Pass test with the key
if (isset($_POST['key'])){
	$coincidence = $test_object->getKeyTest($_POST['key'],$template_object, $_SERVER['DOCUMENT_ROOT'].'/templates/test_questions.tpl');
	if($coincidence==true){
		$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/test_key.tpl');
	}
	else{
		$template_object->setPlaceholder('error_key',  $config_object->getMessageById('msg_error_key'));	
	}
}
//Get results for test with the key
if ((isset($_POST['pass_test']))&&($_POST['pass_test']=='Get Results!')){
	$test_name = $_SESSION["test_name"];
	$key = $_SESSION["key"];
	$test_object->getTestResultsForKey($_POST,$template_object, $_SERVER['DOCUMENT_ROOT'].'/templates/results.tpl',$test_name,$key);
	$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/test_results.tpl');

}

// Check, if user is already logged in.
if ((isset($_POST['login']))&&(isset($_POST['password']))) {
	$id_user = $auth_object->checkUserPassword($_POST['login'],$_POST['password']);
	 //check, if it was "remember me"
	if(isset($_POST['remember'])){
		$remember = $auth_object->generateCode();  //Generate random number
		$mysql = DataBase::getInstance();
		$sql = $mysql->prepare('UPDATE `user` SET `u_remember` =\''.$remember.'\' WHERE `u_id`='.$id_user.''); 
		$sql->execute(); //insert this number to database
		setcookie("remember", $remember, time()+1209600); //set cookie for 2 week
	}
	if ($id_user === NULL) {
		$template_object->setPlaceholder('error_login', $config_object->getMessageById('msg_wrong_password_or_username'));
		$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/authorization_form.tpl');
	}
	else{
		$permission = $auth_object->getPermission($id_user);
		if($permission ==1){ //page for admin
			$test_object->getAllTests($template_object, $_SERVER['DOCUMENT_ROOT'].'/templates/test_link_admin.tpl');
			$template_object->setPlaceholder('generate_key', '');
			$template_object->setPlaceholder('error_permissions', '');
			$template_object->setPlaceholder('error_assign_test', '');
			$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/admin_form.tpl');
		}
		else{ //page for listener
			$test_object->setUserTest($template_object, $_SERVER['DOCUMENT_ROOT'].'/templates/test_link.tpl',$id_user);
			$template_object->setMainTemplate($_SERVER['DOCUMENT_ROOT'].'/templates/listener_form.tpl');
		}
	}
}

$template_object->processTemplate();
echo $template_object->getFinalPage();
