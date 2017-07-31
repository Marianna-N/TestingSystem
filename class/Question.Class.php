<?php
//declare(strict_types=1);

class Question
{	
	private $mysql = false;
		
	public function __construct()
	{
		$this->mysql = DataBase::getInstance();
	}
	
	public function createQuestion (array $q_data,array $q_pic): void
	{
		$q_data = array_map('trim', $q_data);
		$true_answ_key = $q_data["radio-answer"];
		$sql_1 = $this->mysql->prepare('INSERT INTO `question` (`q_title`) VALUES (\''.$q_data["question"].'\')');
		$sql_1->execute();
		$sql_2 = $this->mysql->query('SELECT `q_id` FROM `question` WHERE `q_title` = \''.$q_data["question"].'\'');  //need check for exist question
		$row = $sql_2->fetch(PDO::FETCH_ASSOC);
		$q_id = $row["q_id"]; //var type - string
		settype($q_id, "integer");
		
		$file_path = 'upload_images';
		if(!file_exists($file_path)){
			mkdir($file_path);
		}
		
		if(!empty($q_pic)){
			for($i=0;$i<=count($q_pic);$i++){
				if(isset($q_pic['picture'.$i.''])){ //if admin delete answer $q_pic['picture'.$i.''] may absent
					
					$sql = $this->mysql->prepare('INSERT INTO `picture` (`p_name`,`p_question`) VALUES (:p_name, :p_question)');
					$sql->execute(array(':p_name' => $q_pic['picture'.$i.'']["name"],
										':p_question' => $q_id));
				$uploads_dir = $file_path.'/'.$q_pic['picture'.$i.'']["name"];						
				move_uploaded_file($q_pic['picture'.$i.'']["tmp_name"], $uploads_dir); 

				}
		}
			
		}
		
		for($i=0;$i<=count($q_data);$i++){
			if(isset($q_data['answer'.$i.''])){ //if admin delete answer $q_data['answer'.$i.''] may absent
				$sql = $this->mysql->prepare('INSERT INTO `answer` (`a_text`,`a_question`) VALUES (:a_text, :a_question)');
				$sql->execute(array(':a_text' => $q_data['answer'.$i.''],
									':a_question' => $q_id));
				continue;
			}
		}
		foreach($q_data as $key=>$value){
			if($key == $true_answ_key){
				$true_answ_text = $q_data[$key];
			}		
		}
		//use q_id for exception repeat answer
		$sql = $this->mysql->prepare('UPDATE `answer` SET `a_correct_answer`= TRUE WHERE `a_text`=\''.$true_answ_text.'\' AND `a_question`=\''.$q_id.'\'');
		$sql->execute();
	}
	
	public function setAnswers(Template &$template_object, string $file_content, $q_id) : string
	{
		$result = '';
        $file_content = file_get_contents($file_content);
		$answers = $this->mysql->completeQuery('SELECT * FROM `answer` WHERE `a_question`='.$q_id.'');
		for($i=0;$i<count($answers);$i++){
			$copy = $file_content;
			$copy = str_replace('{ANSWER}', $answers[$i]["a_text"], $copy);
			if ($answers[$i]["a_correct_answer"] == 1){
				$copy = str_replace('{TRUE_ANSWER}', ' - true answer', $copy);
			}
			else{
				$copy = str_replace('{TRUE_ANSWER}', '', $copy);
			}
			$result .= $copy;
		}
			
		return $result;
	}
	
	
	
	 public function setQuestion(Template &$template_object, string $file_content, Test $test_object) : void
    {
        $result = '';
        $file_content = file_get_contents($file_content);
		$file_content2 = $_SERVER['DOCUMENT_ROOT'].'/templates/answer.tpl';
		$questions = $this->mysql->completeQuery("SELECT * FROM `question`");
				
		for($i=0;$i<count($questions);$i++){
			$copy = $file_content;
			$copy = str_replace('{Q_ID}', $questions[$i]["q_id"], $copy);
			$copy = str_replace('{Q_TITLE}', $questions[$i]["q_title"], $copy);
			$copy = str_replace('{PIC}', $test_object->getPictures($template_object,$questions[$i]["q_id"]), $copy);
			$copy = str_replace('{Q_ANSWER}', $this->setAnswers($template_object,$file_content2,$questions[$i]["q_id"]), $copy);
			$result .= $copy;
		}
		
        $template_object->setPlaceholder('created_questions', $result);
    }
	
}
