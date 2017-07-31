<?php
declare(strict_types=1);

class Test
{	
	private $mysql = false;
		
	public function __construct()
	{
		$this->mysql = DataBase::getInstance();
	}
	
	public function setTest(array $test_data):void
	{
		$sql_1 = $this->mysql->prepare('INSERT INTO `test` (`t_name`) VALUES (\''.$test_data["test_name"].'\')');
		$sql_1->execute();
		//get test id
		$sql_2 = $this->mysql->query('SELECT `t_id` FROM `test` WHERE `t_name` = \''.$test_data["test_name"].'\'');  //need check for exist test_name
		$row = $sql_2->fetch(PDO::FETCH_ASSOC);
		$t_id = $row["t_id"]; //var type - string
		settype($t_id, "integer");
		$question = array();
		foreach($test_data as $key=>$value){
			$pos=strpos($key,'question_');
			if($pos === 0){
				$question[] = $value;
			}
		}
		for($i=0;$i<count($question);$i++){
			$sql_3 = $this->mysql->prepare('INSERT INTO `formed_test` (`f_test`,`f_question`) VALUES (:f_test, :f_question)');
			$sql_3->execute(array(':f_test' => $t_id,
								  ':f_question' => $question[$i]));
		}
	}
	
	
	public function setUserTest(Template &$template_object, string $file_content, $id_user) : void
    {
		$result = '';
        $file_content = file_get_contents($file_content);
		$tests = $this->mysql->completeQuery('SELECT `t_id`,`t_name` FROM `assigned_tests`,`test` WHERE `at_user`='.$id_user.' AND `assigned_tests`.`at_test`=`test`.`t_id`');
		if(empty($tests)){
			$template_object->setPlaceholder('assigned_test', 'Tests haven\'t been assigned.');
		}
		else{
			for($i=0;$i<count($tests);$i++){
				
				$copy = $file_content;
				$copy = str_replace('{TEST_NAME}', $tests[$i]["t_name"], $copy);
				$copy = str_replace('{TEST_ID}', $tests[$i]["t_id"], $copy);
				$copy = str_replace('{USER_ID}', $id_user, $copy);
				$result .= $copy;
			}
			$template_object->setPlaceholder('assigned_test', $result);
		}
    }
	public function getAnswers (Template &$template_object, $file_content, $q_id)
	{
		$result = '';
        $file_content = file_get_contents($file_content);
		$answers = $this->mysql->completeQuery('SELECT * FROM `answer` WHERE `a_question`='.$q_id.'');
		for($i=0;$i<count($answers);$i++){
			$copy = $file_content;
			$copy = str_replace('{TEST_ANSWER}', $answers[$i]["a_text"], $copy);
			$copy = str_replace('{ANSWER_ID}', $answers[$i]["a_id"], $copy);
			$copy = str_replace('{Q_ID}', $q_id, $copy);
			$result .= $copy;
		}
		return $result;
		
	}
	public function getPictures (Template &$template_object, $q_id)
	{
		$result = '';
        $file_content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/test_picture.tpl');
		$picture = $this->mysql->completeQuery('SELECT * FROM `picture` WHERE `p_question`='.$q_id.'');
		for($i=0;$i<count($picture);$i++){
			$copy = $file_content;
			$copy = str_replace('{PIC}', $picture[$i]["p_name"], $copy);
			$result .= $copy;
		}
		return $result;
	}
	
	public function getTest(string $test_id, Template &$template_object, string $file_content):void
	{
		$result = '';
        $file_content = file_get_contents($file_content);
		$file_content2 = $_SERVER['DOCUMENT_ROOT'].'/templates/test_answers.tpl';
		$q_id = $this->mysql->completeQuery('SELECT `f_question` FROM `formed_test` WHERE `f_test`='.$test_id.'');
		for($i=0;$i<count($q_id);$i++){
			$question_title = $this->mysql->completeQuery('SELECT `q_title` FROM `question` WHERE `q_id`='.$q_id[$i]["f_question"].'');
			$copy = $file_content;
			$copy = str_replace('{TEST_QUESTION}', $question_title[0]["q_title"], $copy);
			$copy = str_replace('{TEST_PIC}', $this->getPictures($template_object,$q_id[$i]["f_question"]), $copy);
			$copy = str_replace('{TEST_ANSWERS}', $this->getAnswers($template_object,$file_content2,$q_id[$i]["f_question"]), $copy);
			$result .= $copy;
		}
		
		$template_object->setPlaceholder('test_questions', $result);
		
	}
	
	public function getTestResults(array $test_results, Template &$template_object, string $file_content,string $test_name,string $user_id):void
	{
		
		$result = '';
        $file_content = file_get_contents($file_content);
		$corret_answ = 0;
		$incorrect_answ = 0;
		//delete unnecessary array element
		foreach($test_results as $key=>$value){
			if($key == 'pass_test'){
				unset($test_results[$key]);
			}
		}
		foreach($test_results as $key=>$value){
			$copy = $file_content;
			$question_title = $this->mysql->completeQuery('SELECT `q_title` FROM `question` WHERE `q_id`='.$key.'');
			$copy = str_replace('{QUESTION_TITLE}', $question_title[0]["q_title"], $copy);
			$answer_text = $this->mysql->completeQuery('SELECT `a_text` FROM `answer` WHERE `a_id`='.$value.'');
			$copy = str_replace('{USER_ANSWER}', $answer_text[0]["a_text"], $copy);
			$right_answer = $this->mysql->completeQuery('SELECT `a_text` FROM `answer` WHERE `a_question`='.$key.' AND `a_correct_answer`=1');
			$copy = str_replace('{TRUE_ANSWER}', $right_answer[0]["a_text"], $copy);
			$result .= $copy;
			if($answer_text[0]["a_text"] === $right_answer[0]["a_text"]){
				$corret_answ++;
			}
			else{
				$incorrect_answ++;
			}
		}
		//set statistic for test
		$sql = $this->mysql->prepare('UPDATE `test` SET `t_passes`=IFNULL(`t_passes`,0)+1 WHERE `t_name`=\''.$test_name.'\'');
		$sql->execute();
		if(count($test_results)==0){
			$pct = 0;
		}
		else{
		$pct = ($corret_answ*100)/count($test_results); //calculate percent of pass
		}
		$pct=ceil($pct);
		$test_statistic = $this->mysql->completeQuery('SELECT `t_passes`,`t_average_pct`,`t_id` FROM `test` WHERE `t_name`=\''.$test_name.'\'');
		$average_pct = ($pct+$test_statistic[0]["t_average_pct"])/$test_statistic[0]["t_passes"]; //calculate average percent of pass
		$sql_2 = $this->mysql->prepare('UPDATE `test` SET `t_average_pct`= '.$average_pct.' WHERE `t_name`=\''.$test_name.'\'');
		$sql_2->execute();
		//set statistic for user
		$sql_3 = $this->mysql->prepare('INSERT INTO `user_statistics` (`us_user`,`us_test`,`us_percent`) VALUES (:us_user, :us_test, :us_percent)');
		$sql_3->execute(array(':us_user' => $user_id,
							  ':us_test' => $test_statistic[0]["t_id"],
							  ':us_percent' => $pct));
		
		settype($corret_answ, "string");// function setPlaceholder takes only string
		settype($incorrect_answ, "string");
		settype($pct, "string");
		$template_object->setPlaceholder('correct_answers', $corret_answ);
		$template_object->setPlaceholder('incorrect_answers', $incorrect_answ);
		$template_object->setPlaceholder('percentage', $pct);
		$template_object->setPlaceholder('test_name', $test_name);
		$template_object->setPlaceholder('test_results', $result);
	}
	
	public function setTestStatistics(Template &$template_object, string $file_content)
	{
		$result = '';
        $file_content = file_get_contents($file_content);
		$tests = $this->mysql->completeQuery('SELECT * FROM `test`');
		for($i=0;$i<count($tests);$i++){
			$copy = $file_content;
			$copy = str_replace('{TEXT_1}', $tests[$i]["t_name"], $copy);
			$copy = str_replace('{TEXT_2}', $tests[$i]["t_passes"], $copy);
			$copy = str_replace('{TEXT_3}', $tests[$i]["t_average_pct"], $copy);
			$result .= $copy;
		}
		
		$template_object->setPlaceholder('statistics', $result);
	}
	
	public function setUserStatistics(Template &$template_object, string $file_content)
	{
		$result = '';
        $file_content = file_get_contents($file_content);
		$users = $this->mysql->completeQuery('SELECT `u_name`,`u_lastname`,`u_training`,`t_name`,`us_percent` FROM `user_statistics`,`test`,`user` WHERE `user_statistics`.`us_user`=`user`.`u_id` AND `user_statistics`.`us_test`=`test`.`t_id`');
		for($i=0;$i<count($users);$i++){
			$copy = $file_content;
			$copy = str_replace('{TEXT_1}', $users[$i]["u_name"], $copy);
			$copy = str_replace('{TEXT_2}', $users[$i]["u_lastname"], $copy);
			$copy = str_replace('{TEXT_3}', $users[$i]["u_training"], $copy);
			$copy = str_replace('{TEXT_4}', $users[$i]["t_name"], $copy);
			$copy = str_replace('{TEXT_5}', $users[$i]["us_percent"], $copy);
			$result .= $copy;
		}
		
		$template_object->setPlaceholder('statistics', $result);
	}
	
	public function getAllTests(Template &$template_object, string $file_content)
	{
		$result = '';
        $file_content = file_get_contents($file_content);
		$tests = $this->mysql->completeQuery('SELECT * FROM `test`');
		for($i=0;$i<count($tests);$i++){
			$copy = $file_content;
			$copy = str_replace('{TEST_ID}', $tests[$i]["t_id"], $copy);
			$copy = str_replace('{TEST_NAME}', $tests[$i]["t_name"], $copy);
			$result .= $copy;
		}
		$template_object->setPlaceholder('all_tests', $result);
	}
	public function AssignTest (string $u_login, string $t_name, Template &$template_object, Config &$config_object) :void
	{
		$u_login = trim($u_login);
		$t_name = trim($t_name);
		$user = false;
		$test = false;
		$key = 0;
		$user_names = $this->mysql->completeQuery("SELECT `u_login`,`u_id` FROM `user`");
		$test_names = $this->mysql->completeQuery("SELECT `t_name`,`t_id` FROM `test`");
		for($i=0;$i<count($user_names);$i++){
			if($u_login == $user_names[$i]["u_login"])
			{
				$user = true; //login name exists
				$u_id = $user_names[$i]["u_id"];
			}
		}
		//check for key (key has 31 symbols)
		if(strlen($u_login)==31){
			$user = true;// this is key
			$key = $u_login;
		}
		for($i=0;$i<count($test_names);$i++){
			if($t_name == $test_names[$i]["t_name"])
			{
				$test = true; //test name exists
				$t_id = $test_names[$i]["t_id"];
			}
		}
		if($user == false && $test == false){
			$template_object->setPlaceholder('error_assign_test', $config_object->getMessageById('msg_error_assign'));
		}
		elseif($test == false){
			$template_object->setPlaceholder('error_assign_test', $config_object->getMessageById('msg_error_test'));
		}
		elseif($user == false){
			$template_object->setPlaceholder('error_assign_test', $config_object->getMessageById('msg_error_login'));
		}
		elseif($key !== 0){
			$template_object->setPlaceholder('error_assign_test', 'Key was assigned!');
			$sql = $this->mysql->prepare('INSERT INTO `guest` (`g_key`,`g_test`) VALUES (:g_key, :g_test)');
			$sql->execute(array(':g_key' => $key,
								':g_test' => $t_id));			
		}
		else{
			$template_object->setPlaceholder('error_assign_test', 'Test was assigned!');
			$sql = $this->mysql->prepare('INSERT INTO `assigned_tests` (`at_user`,`at_test`) VALUES (:at_user, :at_test)');
			$sql->execute(array(':at_user' => $u_id,
								':at_test' => $t_id));
		}

	}
	
	public function getKeyTest (string $key, Template &$template_object, string $file_content):bool
	{
		$key = trim($key);
		$coincidence = false; 
		$all_key = $this->mysql->completeQuery('SELECT * FROM `guest`');
		for($i=0;$i<count($all_key);$i++){
			if($key == $all_key[$i]["g_key"]){
				$coincidence = true; 
				$test_id =  $all_key[$i]["g_test"];
			}
		}		
		if($coincidence == true){
		$test_name = $this->mysql->completeQuery('SELECT `t_name` FROM `test` WHERE `t_id`= \''.$test_id.'\'');
		$template_object->setPlaceholder('test_name', $test_name[0]["t_name"]);
		$_SESSION["test_name"]= $test_name[0]["t_name"];
		$_SESSION["key"]= $key;
		$result = '';
        $file_content = file_get_contents($file_content);
		$file_content2 = $_SERVER['DOCUMENT_ROOT'].'/templates/test_answers.tpl';
		$q_id = $this->mysql->completeQuery('SELECT `f_question` FROM `formed_test` WHERE `f_test`='.$test_id.'');
		for($i=0;$i<count($q_id);$i++){
			$question_title = $this->mysql->completeQuery('SELECT `q_title` FROM `question` WHERE `q_id`='.$q_id[$i]["f_question"].'');
			$copy = $file_content;
			$copy = str_replace('{TEST_QUESTION}', $question_title[0]["q_title"], $copy);
			$copy = str_replace('{TEST_PIC}', $this->getPictures($template_object,$q_id[$i]["f_question"]), $copy);
			$copy = str_replace('{TEST_ANSWERS}', $this->getAnswers($template_object,$file_content2,$q_id[$i]["f_question"]), $copy);
			$result .= $copy;
		}
		
		$template_object->setPlaceholder('test_questions', $result);
		}
		return $coincidence;
		
	}
	public function getTestResultsForKey (array $test_results, Template &$template_object, string $file_content,string $test_name,$user_key):void
	{
		if(empty($test_results)){
			exit();
		}
		$result = '';
        $file_content = file_get_contents($file_content);
		$corret_answ = 0;
		$incorrect_answ = 0;
		//delete unnecessary array element
		foreach($test_results as $key=>$value){
			if($key == 'pass_test'){
				unset($test_results[$key]);
			}
		}
		foreach($test_results as $key=>$value){
			$copy = $file_content;
			$question_title = $this->mysql->completeQuery('SELECT `q_title` FROM `question` WHERE `q_id`='.$key.'');
			$copy = str_replace('{QUESTION_TITLE}', $question_title[0]["q_title"], $copy);
			$answer_text = $this->mysql->completeQuery('SELECT `a_text` FROM `answer` WHERE `a_id`='.$value.'');
			$copy = str_replace('{USER_ANSWER}', $answer_text[0]["a_text"], $copy);
			$right_answer = $this->mysql->completeQuery('SELECT `a_text` FROM `answer` WHERE `a_question`='.$key.' AND `a_correct_answer`=1');
			$copy = str_replace('{TRUE_ANSWER}', $right_answer[0]["a_text"], $copy);
			$result .= $copy;
			if($answer_text[0]["a_text"] === $right_answer[0]["a_text"]){
				$corret_answ++;
			}
			else{
				$incorrect_answ++;
			}
		}
		if(count($test_results)==0){
			$pct = 0;
		}
		else{
		$pct = ($corret_answ*100)/count($test_results); //calculate percent of pass
		}
		$pct=ceil($pct);
		settype($corret_answ, "string");// function setPlaceholder takes only string
		settype($incorrect_answ, "string");
		settype($pct, "string");
		$sql = $this->mysql->prepare('DELETE FROM `guest` WHERE `g_key`=\''.$user_key.'\'');
		$sql->execute();
		$template_object->setPlaceholder('correct_answers', $corret_answ);
		$template_object->setPlaceholder('incorrect_answers', $incorrect_answ);
		$template_object->setPlaceholder('percentage', $pct);
		$template_object->setPlaceholder('test_name', $test_name);
		$template_object->setPlaceholder('test_results', $result);
	}
}
