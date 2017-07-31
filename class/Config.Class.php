<?php
class Config
{
	private $config = array();
	public $message = array();
	private $label = array();

	public function __construct()
	{
		$mysql = DataBase::getInstance();
		
		$r = $mysql->query("SELECT * FROM `message`");
		while ($row = $r->fetch(PDO::FETCH_ASSOC)){
				$this->message[$row['m_name']] = $row['m_value'];
			}
		//var_dump($this->message);
		
		/*$stmt = $mysql->prepare("INSERT INTO `label` (`l_name`, `l_value`)
                                                 VALUES (:l_name, :l_value)");
		$stmt->execute(array(':l_name' => 'test_name',':l_value' => 'test_value'));
		var_dump($stmt);*/
		$r = $mysql->query("SELECT * FROM `label`");
		while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
			$this->label[$row['l_name']] = $row['l_value'];
		}
		//var_dump($this->label);
	}
	
	/*public function getTemplatesLocation() : string
	{
		if (trim($this->config['templates_location'])=='') {
			return $_SERVER['DOCUMENT_ROOT'].'/templates';
		}
		else {
			return $this->config['templates_location'];
		}
	}*/
	
	public function getMessageById(string $id) : string
	{
		if (isset($this->message[$id])) {
			return $this->message[$id];
		}
		else {
			throw new Exception('Broken config. Message ['.$id.'] is missing.');
		}	
	}
	
	public function getLabelById(string $id) : string
	{
		if (isset($this->label[$id])) {
			return $this->label[$id];
		}
		else {
			throw new Exception('Broken config. Label ['.$id.'] is missing.');
		}	
	}
	

	
}